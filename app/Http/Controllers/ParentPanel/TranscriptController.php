<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolList;

use DB;




class TranscriptController extends Controller
{
  

    public function index(Request $request)
    {
         $destinations = SchoolList::getDestination();
        $perPage = $request->get('perPage', 5);
        $studentId =  Student::where('parent_guardian_id', Auth::id())->first()->id;

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

        $hasTranscripts = $transcripts->count() > 0;
        return view('parent-panel.transcript',compact('transcripts', 'destinations', 'hasTranscripts', 'perPage'));
    }

   
}
