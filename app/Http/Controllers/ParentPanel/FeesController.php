<?php

namespace App\Http\Controllers\ParentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Repositories\Fees\FeesCollectRepository;
use App\Repositories\ParentPanel\FeesRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\Student;
use App\Models\SchoolList;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class FeesController extends Controller
{
    private $repo;
    private $feesCollectRepository;

    function __construct(FeesRepository $repo, FeesCollectRepository $feesCollectRepository)
    {
        $this->repo = $repo;
        $this->feesCollectRepository = $feesCollectRepository;
    }



    public function index(Request $request)
    {
        $studentId = session('current_student_id');

        // School years
        $yearOptions = DB::table('school_years')
            ->pluck('name', 'id')
            ->toArray();

        // ================== FETCH DATA ==================
        $feesData = DB::table('fees_installment_children as fic')

            ->join('fees_assign_childrens as fac', function ($join) {
                $join->on('fac.id', '=', 'fic.fees_assign_id')
                    ->on('fac.fees_master_id', '=', 'fic.fees_master_id');
            })

            ->join('fees_masters as fm', 'fm.id', '=', 'fic.fees_master_id')
            ->join('fees_groups as fg', 'fg.id', '=', 'fm.fees_group_id')
            ->join('fees_types as ft', 'ft.id', '=', 'fm.fees_type_id')

            ->leftJoin(
                'payment_transactions as pt',
                'pt.fees_assign_childrens_installment_id',
                '=',
                'fic.id'
            )

            ->where('fic.student_id', $studentId)

            ->select([
                // installment
                'fic.id as installment_id',
                'fic.amount as installment_amount',
                'fic.due_date as installment_due_date',

                // assign children
                'fac.overdue_days',          // 👉 GRACE PERIOD (days)
                'fac.fine_amount',           // 👉 PER DAY FINE
                'fac.payment_method',

                // group & type
                'fg.name as fees_group_name',
                'ft.name as fees_type_name',

                // payment
                'pt.id as payment_transaction_id',
                'pt.transaction_id',
                'pt.created_at as payment_date',
            ])

            ->orderBy('fic.due_date', 'asc')
            ->get();

        // ================== CALCULATION LOGIC ==================
        $today = Carbon::today();

        $feesData = $feesData->map(function ($fee) use ($today) {

            $dueDate   = Carbon::parse($fee->installment_due_date);
            $graceDays = (int) ($fee->overdue_days ?? 0); // GRACE PERIOD
            $finePerDay = (float) ($fee->fine_amount ?? 0);

            $graceEndDate = $dueDate->copy()->addDays($graceDays);

            $isPaid = !empty($fee->payment_transaction_id);

            // Default values
            $fee->status_text  = 'Upcoming';
            $fee->status_class = 'red-bg';
            $fee->fine_calculated = 0;
            $fee->final_amount = $fee->installment_amount;

            // PAID
            if ($isPaid) {
                $fee->status_text  = 'Paid';
                $fee->status_class = 'green-bg';
                return $fee;
            }

            // AFTER GRACE PERIOD → FINE APPLIES
            if ($today->gt($graceEndDate)) {

                $lateDays = $graceEndDate->diffInDays($today);
                $fee->fine_calculated = $lateDays * $finePerDay;

                $fee->final_amount =
                    $fee->installment_amount + $fee->fine_calculated;

                $fee->status_text  = 'Unpaid';
                $fee->status_class = 'orange-bg';
            }

            return $fee;
        });

        return view('parent-panel.fees', [
            'feesData'    => $feesData,
            'yearOptions' => $yearOptions,
        ]);
    }



    public function payModal(Request $request)
    {
        return view('common.fee-pay.fee-pay-modal', [
            'feeAssignChildren' => FeesAssignChildren::with('feesMaster')->where('id', $request->fees_assigned_children_id)->first(),
            'formRoute' => route('parent-panel-fees.pay-with-stripe'),
            'paypalRoute' => route('parent-panel-fees.pay-with-paypal'),
        ]);
    }


    public function payWithStripe(Request $request)
    {
        try {
            $this->feesCollectRepository->payWithStripeStore($request);

            return back()->with('success', ___('alert.Fee has been paid successfully'));
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }





    public function payWithPaypal(Request $request)
    {
        loadPayPalCredentials();

        Session::put('FeesAssignChildrenID', $request->fees_assign_children_id);

        $provider   = new ExpressCheckout;
        $data       = $this->feesCollectRepository->paypalOrderData(uniqid(), route('parent-panel-fees.payment.success'), route('parent-panel-fees.payment.cancel'));
        $response   = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }





    public function paymentSuccess(Request $request)
    {
        loadPayPalCredentials();

        try {
            $provider   = new ExpressCheckout;
            $token      = $request->token;
            $PayerID    = $request->PayerID;
            $response   = $provider->getExpressCheckoutDetails($token);

            $invoiceID  = $response['INVNUM'] ?? uniqid();
            $data       = $this->feesCollectRepository->paypalOrderData($invoiceID, route('parent-panel-fees.payment.success'), route('parent-panel-fees.payment.cancel'));
            $response   = $provider->doExpressCheckoutPayment($data, $token, $PayerID);

            $feesAssignChildren = optional(FeesAssignChildren::with('feesMaster')->where('id', session()->get('FeesAssignChildrenID'))->first());

            if ($feesAssignChildren && $response['PAYMENTINFO_0_TRANSACTIONID']) {
                $this->feesCollectRepository->feeCollectStoreByPaypal($response, $feesAssignChildren);
            }

            session()->forget('FeesAssignChildrenID');

            return redirect()->route('parent-panel-fees.index', ['student_id' => $feesAssignChildren->student_id])->with('success', ___('alert.Fee has been paid successfully'));
        } catch (\Throwable $th) {

            return redirect()->route('parent-panel-fees.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }





    public function paymentCancel()
    {
        return redirect()->route('parent-panel-fees.index')->with('danger', ___('alert.Payment cancelled!'));
    }
}
