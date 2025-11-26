<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\Subject;
use App\Models\Attendance\Attendance;
use App\Models\Leave;
use App\Models\NoticeBoard;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\Student;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicateController extends Controller
{

    public function index(){

        return view('staff.communicate.index');

    }


    public function addMessage(){

        return view('staff.communicate.add-message');

    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'message'     => 'required|string',
            'document'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        $teacherId = Auth::id();
        $session   = currentSession();

        $attachmentId = null;
        if ($request->hasFile('document')) {
            $file     = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs('noticeboard_attachments', $filename, 'public');

            // Manual creation – bypasses mass assignment completely
            $upload           = new Upload();
            $upload->path     = $path;
            $upload->created_at = now();
            $upload->updated_at = now();
            $upload->save();

            $attachmentId = $upload->id;
        }

        // Create NoticeBoard instance manually (safe when no $fillable)
        $notice = new NoticeBoard();

        $notice->title           = $request->title;
        $notice->session_id      = $session->session_id ?? null;
        $notice->year_status_id  = $session->year_status_id ?? null;
        $notice->semester_id     = $session->semester_id ?? null;
        $notice->class_id        = null;
        $notice->section_id      = null;
        $notice->student_id      = null;
        $notice->teacher_id      = $teacherId;
        $notice->date            = $request->date;
        $notice->publish_date    = $request->date;
        $notice->department_id   = null;
        $notice->description     = $request->message;
        $notice->attachment      = $attachmentId;
        $notice->status          = 1;
        $notice->target_id       = null;
        $notice->created_at = now();
        $notice->updated_at = now();

        $notice->save();
        return response()->json([
            'success' => true,
            'message' => 'Message published successfully!'
        ]);
    }


}