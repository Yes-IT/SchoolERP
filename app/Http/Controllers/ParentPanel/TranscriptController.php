<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\Applicant\PaymentTransaction;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolList;
use App\Models\Transcript;
use Illuminate\Support\Facades\DB;


class TranscriptController extends Controller
{
  

    public function index(Request $request)
    {
        $destinations = SchoolList::getDestination();
        $perPage = $request->get('perPage', 5);

        $student = $request->attributes->get('currentStudent');
            
        if (!$student) {
            return redirect()
                ->route('parent-panel-dashboard.index')
                ->with('error', 'Please select a student first');
        }

        $studentId = $student->id;
        // dd($studentId);

        $transcripts = DB::table('transcripts')
                        ->leftJoin('payment_transactions', 'transcripts.payment_transactions_id', '=', 'payment_transactions.id')
                        ->where('transcripts.student_id', $studentId)
                        ->select(
                            'transcripts.*',
                            'payment_transactions.transaction_id',
                            'payment_transactions.amount',
                            'payment_transactions.status as payment_status',
                            'payment_transactions.auth_code',
                            'payment_transactions.card_last4',
                            'payment_transactions.type',
                            'payment_transactions.created_at as payment_date',
                            'transcripts.destination as destination',
                            'transcripts.payment_requirement as payment_requirement',

                        )
                        ->orderBy('transcripts.created_at', 'desc')
                        ->paginate($perPage);

        // $hasTranscripts = $transcripts->count() > 0;
        $hasTranscripts = $transcripts->total() > 0;
        return view('parent-panel.transcript',compact('transcripts', 'destinations', 'hasTranscripts', 'perPage'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'destination'        => 'required|string|max:255',
            'card_holder_name'   => 'required|string|max:255',
            'billing_card'       => 'required|string', // will be masked later
            'exp_date'           => 'required|string', // MM/YYYY
            'security_code'      => 'required|string|size:3|regex:/^\d+$/',
        ]);

        $studentId = session('selected_student_id');

        // TODO: Integrate your actual payment gateway here
        // For now, assuming payment is successful and you get response like in your example
        // Replace this dummy data with real gateway response
        $paymentResponse = [
            'transaction_id' => '10800100085', // from gateway
            'status'         => 'Approved',
            'auth_code'      => '68376A',
            'amount'         => '1.00',
            'card_last4'     => substr(str_replace([' ', '-'], '', $request->billing_card), -4),
            'response_raw'   => json_encode([
                'xResult' => 'A',
                'xStatus' => 'Approved',
                'xRefNum' => '10800100085',
                'xName'   => $request->card_holder_name,
                'xMaskedCardNumber' => '4xxxxxxxxxxx' . substr(str_replace([' ', '-'], '', $request->billing_card), -4),
            ]),
        ];

        // 1. Create Payment Transaction Record
        $paymentTransaction = PaymentTransaction::create([
            'student_id'     => 2,
            'type'           => 'student_request_transcript',
            'transaction_id' => $paymentResponse['transaction_id'],
            'status'         => $paymentResponse['status'],
            'auth_code'      => $paymentResponse['auth_code'],
            'amount'         => $paymentResponse['amount'],
            'card_last4'     => $paymentResponse['card_last4'],
            'response_raw'   => $paymentResponse['response_raw'],
            // applicant_id, fees_assign_childrens_id, deleted_at remain NULL
        ]);

        // 2. Create Transcript Request (Paid)
        Transcript::create([
            'student_id'               => 2,
            'payment_transactions_id'  => $paymentTransaction->id,
            'destination'              => $request->destination,
            'payment_requirement'      => 'yes',
            'payment_status'           => 'approved', 
            'payment_receipt_link'     => null, 
            'status'                   => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transcript request submitted successfully.'
        ]);
    }

    public function storeFree(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
        ]);

        $studentId = session('current_student_id');

        Transcript::create([
            'student_id'               => 2,
            'payment_transactions_id'  => null,
            'destination'              => $request->destination,
            'payment_requirement'      => 'no',
            'payment_status'           => 'approved',  // or null / 'N/A'
            'payment_receipt_link'     => null,
            'status'                   => 1,            // Approved immediately (free)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Free transcript request submitted successfully.'
        ]);
    }

   
}
