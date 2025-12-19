<?php

namespace App\Http\Controllers\ParentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Repositories\Fees\FeesCollectRepository;
use App\Repositories\ParentPanel\FeesRepository;
use App\Models\StudentInfo\Student;
use App\Models\SchoolList;
use Illuminate\Support\Facades\{Auth,DB,Log};




class FeesController extends Controller
{
    private $repo;
    private $feesCollectRepository;

    function __construct(FeesRepository $repo, FeesCollectRepository $feesCollectRepository)
    {
        $this->repo = $repo;
        $this->feesCollectRepository = $feesCollectRepository;
    }

    // public function index(Request $request)
    // {
    //     $student = Student::where('parent_guardian_id', Auth::id())->first();


    //     if (!$student) {
    //         return redirect()->back()->withErrors(['error' => 'Student not found.']);
    //     }
    //     $yearOptions = DB::table('school_years')
    //         ->pluck('name', 'id')
    //         ->toArray();

    //     $query = DB::table('fees_assign_childrens as fac')
    //         ->leftjoin('fees_masters as fm', 'fm.id', '=', 'fac.fees_master_id')
    //         ->leftjoin('fees_types as ft', 'ft.id', '=', 'fm.fees_type_id')
    //         ->select(
    //             'fac.id as id',
    //             'ft.name as type',
    //             'fm.due_date',
    //             'fm.amount'
    //         )
    //         ->where('fac.student_id', $student->id);



    //     if ($request->filled('year')) {
    //         $yearName = DB::table('school_years')->where('id', $request->year)->value('name');

    //         if ($yearName) {
    //             [$yearStart, $yearEnd] = explode('-', $yearName);
    //             $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth();
    //             $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();

    //             $query->whereBetween('fm.due_date', [$startOfYear, $endOfYear]);
    //         }
    //     }

    //     // $fees = $query->get();

    //     $perPage = $request->get('perPage', 10);
    //     $fees = $query->paginate($perPage);

    //     $destinations = SchoolList::getDestination();
    //     return view('parent-panel.fees',  [
    //         'yearOptions' => $yearOptions,
    //         'fees' => $fees,
    //         'selectedYear' => $request->year,
    //         'perPage' => $perPage,
    //         'destinations' => $destinations
    //     ]);
    // }

    public function index(Request $request)
    {
        try{
            $student = request()->get('currentStudent');
            if (!$student) {
                $studentId = session('current_student_id');
                if (!$studentId) {
                    return redirect()->route('parent-panel-dashboard.index')->with('error', 'Please select a student first');
                }
                
                $student = Student::where('id', $studentId)->where('parent_guardian_id', Auth::id())->first();
                if (!$student) {
                    return redirect()->route('parent-panel-dashboard.index')->with('error', 'Invalid student selected');
                }
            }

            $studentId = $student->id;
            Log::info('student id', ['student id' => $studentId]);

            $years     = Session::orderByDesc('id')->get();

            $query = DB::table('fees_assign_childrens as fac')
                        ->leftjoin('fees_masters as fm', 'fm.id', '=', 'fac.fees_master_id')
                        ->leftjoin('fees_types as ft', 'ft.id', '=', 'fm.fees_type_id')
                        ->select(
                            'fac.id as id',
                            'ft.name as type',
                            'fm.due_date',
                            'fm.amount'
                        )
                        ->where('fac.student_id', $studentId);
           
            $perPage = $request->get('perPage', 10);
            $fees = $query->get();  

            return view('parent-panel.fees',  [
            'yearOptions' => $years,
            'fees' => $fees,
            'selectedYear' => $request->year,
            'perPage' => $perPage,
           
        ]);            


        }catch(\Exception $e){
            Log::info(' my tuition fees error', ['error' => $e->getMessage()]);
            return redirect()->route('parent-panel-dashboard.index')->with('error', 'Invalid student selected');
        }
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
