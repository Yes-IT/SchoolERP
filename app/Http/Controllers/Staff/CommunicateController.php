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
use Illuminate\Support\Facades\Storage;

class CommunicateController extends Controller
{

    public function index()
    {
        $teacherId = Auth::id();

        // 1. Messages created by this teacher
        $myMessages = NoticeBoard::where('teacher_id', $teacherId)
            ->with('attachmentFile') // eager load attachment
            ->latest('date')
            ->get();

        // 2. Global notices (no specific recipient)
        $globalNotices = NoticeBoard::whereNull('year_status_id')
            ->whereNull('semester_id')
            ->whereNull('class_id')
            ->whereNull('section_id')
            ->whereNull('student_id')
            ->whereNull('teacher_id')
            ->with('attachmentFile')
            ->latest('date')
            ->get();

        // Combine both (teacher's + global), remove duplicates if any
        $notices = $myMessages->merge($globalNotices)
            ->sortByDesc('date')
            ->values();

        return view('staff.communicate.index', compact('notices'));
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



    public function editMessage($id)
    {
        $notice = NoticeBoard::where('id', $id)
            ->where('teacher_id', Auth::id())
            ->with('attachmentFile')
            ->firstOrFail();

        return view('staff.communicate.edit-message', compact('notice'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'date'     => 'required|date',
            'message'  => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        $notice = NoticeBoard::where('id', $id)
                    ->where('teacher_id', Auth::id())
                    ->firstOrFail();

        $notice->title       = $request->title;
        $notice->date        = $request->date;
        $notice->publish_date = $request->date;
        $notice->description = $request->message;

        // THIS IS THE ONLY CHANGE NEEDED — EXACTLY LIKE YOUR STORE METHOD
        if ($request->hasFile('document')) {
            // Delete old file exactly like you would want
            if ($notice->attachment) {
                $old = Upload::find($notice->attachment);
                if ($old) {
                    Storage::disk('public')->delete($old->path);
                    $old->delete();
                }
            }

            // Reuse YOUR perfect upload pattern
            $file     = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs('noticeboard_attachments', $filename, 'public');

            $upload       = new Upload();
            $upload->path = $path;
            $upload->save();

            $notice->attachment = $upload->id;
        }

        $notice->save();

        return response()->json([
            'success' => true,
            'message' => 'Message updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $notice = NoticeBoard::where('id', $id)
                    ->where('teacher_id', Auth::id())
                    ->firstOrFail();

        // Delete attachment file if exists
        if ($notice->attachment) {
            $upload = Upload::find($notice->attachment);
            if ($upload) {
                Storage::disk('public')->delete($upload->path);
                $upload->delete();
            }
        }

        $notice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully!'
        ]);
    }


}