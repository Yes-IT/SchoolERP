<?php

namespace App\Http\Controllers\ParentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use Illuminate\Support\Facades\Session;
use App\Models\StudentInfo\Student;
use App\Models\SchoolList;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{DB,Log,Http,Auth};



class FeesController extends Controller
{
  
    // public function index(Request $request)
    // {
    //     try{

    //         $studentId = session('current_student_id');
    //     // dd($studentId);

    //         $yearOptions = DB::table('school_years')
    //                         ->pluck('name', 'id')
    //                         ->toArray();
           

    //         $feesData = DB::table('fees_installment_children as fic')
    //                     ->join('fees_assign_childrens as fac', function ($join) {
    //                         $join->on('fac.id', '=', 'fic.fees_assign_id')
    //                             ->on('fac.fees_master_id', '=', 'fic.fees_master_id');
    //                     })
    //                     ->join('fees_masters as fm', 'fm.id', '=', 'fic.fees_master_id')
    //                     ->join('fees_groups as fg', 'fg.id', '=', 'fm.fees_group_id')
    //                     ->join('fees_types as ft', 'ft.id', '=', 'fm.fees_type_id')
    //                     ->leftJoin(
    //                         'payment_transactions as pt',
    //                         'pt.fees_assign_childrens_installment_id',
    //                         '=',
    //                         'fic.id'
    //                     )
    //                     ->where('fic.student_id', $studentId)
    //                     ->select([
    //                         'fic.id as installment_id',
    //                         'fic.amount as installment_amount',
    //                         'fic.due_date as installment_due_date',

    //                         'fac.overdue_days',         
    //                         'fac.fine_amount',         
    //                         'fac.payment_method',

    //                         'fg.name as fees_group_name',
    //                         'ft.name as fees_type_name',

    //                         'pt.id as payment_transaction_id',
    //                         'pt.transaction_id',
    //                         'pt.created_at as payment_date',
    //                     ])
    //                     ->orderBy('fic.due_date', 'asc')
    //                     ->get();


           

    //         // ================== CALCULATION LOGIC ==================
    //         $today = Carbon::today();

    //         $feesData = $feesData->map(function ($fee) use ($today) {

    //             $dueDate   = Carbon::parse($fee->installment_due_date);
    //             $graceDays = (int) ($fee->overdue_days ?? 0); 
    //             $finePerDay = (float) ($fee->fine_amount ?? 0);

    //             $graceEndDate = $dueDate->copy()->addDays($graceDays);

    //             $isPaid = !empty($fee->payment_transaction_id);

    //             $fee->status_text  = 'Upcoming';
    //             $fee->status_class = 'red-bg';
    //             $fee->fine_calculated = 0;
    //             $fee->final_amount = $fee->installment_amount;

    //             if ($isPaid) {
    //                 $fee->status_text  = 'Paid';
    //                 $fee->status_class = 'green-bg';
    //                 return $fee;
    //             }

    //             // AFTER GRACE PERIOD → FINE APPLIES
    //             if ($today->gt($graceEndDate)) {

    //                 $lateDays = $graceEndDate->diffInDays($today);
    //                 $fee->fine_calculated = $lateDays * $finePerDay;

    //                 $fee->final_amount = $fee->installment_amount + $fee->fine_calculated;

    //                 $fee->status_text  = 'Unpaid';
    //                 $fee->status_class = 'orange-bg';
    //             }

    //             return $fee;
    //         });

    //     //    dd($feesData);

    //         return view('parent-panel.fees', [
    //             'feesData'    => $feesData,
    //             'yearOptions' => $yearOptions,
    //         ]);
    //     }catch(\Exception $e){
    //         Log::error('My tuition fee error',$e->getMessage());
    //         return redirect()->route('parent-panel-dashboard.index')->with('error', 'Please try again later.');

    //     }
       
    // }
    public function index(Request $request)
    {
        try{
            $studentId = session('current_student_id');

            $yearOptions = DB::table('school_years')
                            ->pluck('name', 'id')
                            ->toArray();

            $perPage = $request->get('per_page', 10);
            
            $feesQuery = DB::table('fees_installment_children as fic')
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
                            'fic.id as installment_id',
                            'fic.amount as installment_amount',
                            'fic.due_date as installment_due_date',

                            'fac.overdue_days',         
                            'fac.fine_amount',         
                            'fac.payment_method',

                            'fg.name as fees_group_name',
                            'ft.name as fees_type_name',

                            'pt.id as payment_transaction_id',
                            'pt.transaction_id',
                            'pt.created_at as payment_date',
                        ])
                        ->orderBy('fic.due_date', 'asc');

            $feesData = $feesQuery->paginate($perPage);

            // ================== CALCULATION LOGIC ==================
            $today = Carbon::today();

            $feesData->getCollection()->transform(function ($fee) use ($today) {

                $dueDate   = Carbon::parse($fee->installment_due_date);
                $graceDays = (int) ($fee->overdue_days ?? 0); 
                $finePerDay = (float) ($fee->fine_amount ?? 0);

                $graceEndDate = $dueDate->copy()->addDays($graceDays);

                $isPaid = !empty($fee->payment_transaction_id);

                $fee->status_text  = 'Upcoming';
                $fee->status_class = 'red-bg';
                $fee->fine_calculated = 0;
                $fee->final_amount = $fee->installment_amount;

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
        }catch(\Exception $e){
            Log::error('My tuition fee error',$e->getMessage());
            return redirect()->route('parent-panel-dashboard.index')->with('error', 'Please try again later.');
        }
       
    }


    public function storePaymentParentFee(Request $request)
    {
        Log::info('storePaymentParentFee() called', [
            'request' => $request->all(),
        ]);

        $request->validate([
            'amount'           => 'required|numeric|min:0.01',
            'billing_card'     => 'required',
            'exp_date'         => 'required',
            'security_code'    => 'required',
            'card_holder_name' => 'required',
            'installment_id'   => 'required'
        ]);

        $xKey = "yesitlabsdev8487f53129e34ed48f612f876da78bba";
        $user_id = Auth::id();
        $email = Auth::user()->email;
        $studentId = session('current_student_id');

        $expDate = str_replace('/', '-', $request->exp_date);
        $parts = explode('-', $expDate);

        $month = '';
        $year = '';

        if (count($parts) >= 2) {
            if (strlen($parts[0]) == 4) {
                $year = substr($parts[0], -2);
                $month = $parts[1];
            } elseif (strlen($parts[1]) == 4) {
                $month = $parts[0];
                $year = substr($parts[1], -2);
            }
        }

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $exp = $month . $year;

        $paymentAmount = $request->amount;

        // Test mode logic if needed
        if (app()->environment('local') || app()->environment('testing')) {
            if ($paymentAmount > 4500) {
                $paymentAmount = 1.00;
            }
        }

        $paymentData = [
            "xKey" => $xKey,
            "xVersion" => "5.0.0",
            "xSoftwareName" => "School ERP",
            "xSoftwareVersion" => "1.0",
            "xCommand" => "cc:sale",
            "xAmount" => $paymentAmount,
            "xInvoice" => "INV-PARENT-" . time(),
            "xCardNum" => preg_replace('/\s+/', '', $request->billing_card),
            "xExp" => $exp,
            "xCVV" => $request->security_code,
            "xName" => $request->card_holder_name,
            "xEmail" => $email,
            "xAllowDuplicate" => "true",
        ];

        $response = Http::asForm()->timeout(45)->post(
            'https://x1.cardknox.com/gateway',
            $paymentData
        );

        if ($response->failed()) {
            Log::error('Payment gateway request failed', [
                'response' => $response->body(),
                'paymentData' => $paymentData

            ]);

            return back()->with('error', 'Payment gateway request failed: ' . $response->body());
        }

        parse_str($response->body(), $paymentResult);

        if (($paymentResult['xStatus'] ?? '') !== 'Approved') {
            return back()->with('error', ($paymentResult['xError'] ?? 'Payment failed.'));
        }

        DB::beginTransaction();

        try {
            $installment = DB::table('fees_installment_children')
                            ->where('id', $request->installment_id)
                            ->where('student_id', $studentId)
                            ->first();

            if (!$installment) {
                throw new \Exception('Installment not found');
            }

            $payment_trans = DB::table('payment_transactions')->insertGetId([
                                'transaction_id' => $paymentResult['xRefNum'] ?? null,
                                'amount' => $paymentAmount,
                                'status' => $paymentResult['xStatus'] ?? 'Unknown',
                                'auth_code' => $paymentResult['xAuthCode'] ?? null,
                                'card_last4' => substr($request->billing_card, -4),
                                'response_raw' => json_encode($paymentResult),
                                'type' => "parent_fee",
                                // 'parent_id' => $user_id,
                                'student_id' => $studentId,
                                'fees_assign_childrens_installment_id' => $request->installment_id,
                                'fees_assign_childrens_id' => $installment->fees_assign_id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

            DB::table('fees_installment_children')
                    ->where('id', $request->installment_id)
                    ->where('student_id', $studentId)
                    ->update([
                        'status' => '1', 
                        'updated_at' => now(),
                    ]);

            $allInstallments = DB::table('fees_installment_children')
                                ->where('fees_assign_id', $installment->fees_assign_id)
                                ->where('student_id', $studentId)
                                ->get();

            $allPaid = $allInstallments->every(function ($inst) {
                return $inst->status == '1';
            });

            $assignUpdateData = [
                'updated_at' => now(),
            ];

            if ($allPaid) {
                $assignUpdateData['status'] = '1'; 
            }

            DB::table('fees_assign_childrens')
                ->where('id', $installment->fees_assign_id)
                ->where('student_id', $studentId)
                ->update($assignUpdateData);

            DB::commit();

            $message = 'Payment of $' . number_format($paymentAmount, 2) . ' successful!';
            if ($allPaid) {
                $message .= ' All installments for this fee are now paid.';
            }

            return redirect()->route('parent-panel.fees')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Payment processing failed: ' . $e->getMessage());
            
            return back()->with('error', 'Payment processing failed. Please try again. Error: ' . $e->getMessage());
        }
    }

   


  




   





  
}
