<?php

namespace App\Http\Controllers\ParentPanel;

use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Search;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\ParentPanel\DashboardRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $repo;

    function __construct(DashboardRepository $repo)
    {
        $this->repo               = $repo;
    }

    public function index(Request $request)
    {

        $first_student = Student::where('parent_guardian_id', Auth::id())->first();
        $student = Student::where('user_id', $first_student->user_id)->first();
        $students = DB::table('students')
            ->join('student_class_mapping', 'students.id', '=', 'student_class_mapping.student_id')
            ->whereNull('students.parent_guardian_id')
            // ->where('parent_guardian_id', '!=', '')
            ->get();

        if (!$student) {

            return view('parent-panel.dashboard-upload', compact('students'));
        }

        // 2️ Get student_id
        // $studentId = $student->id;
        $studentId = session('selected_student_id');
        // @dd($studentId);
        // 3️ Get all class_ids for this student
        $classIds = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->pluck('class_id')
            ->toArray();

        if (empty($classIds)) {
            return view('parent-panel.dashboard-upload', compact('students'));
        }

        // 4️ Get all teacher_ids from classes table for those classes
        $teacherIds = DB::table('classes')
            ->whereIn('id', $classIds)
            ->pluck('teacher_id')
            ->filter() // remove nulls
            ->unique()
            ->toArray();

        if (empty($teacherIds)) {
            return view('parent-panel.dashboard-upload', compact('students'));
        }

        // 5️ Get all staff (teachers) details using those teacher_ids
        $staff = DB::table('staff')
            ->whereIn('id', $teacherIds)
            ->get();

        // 6️ Get user and upload info for profile (same as your logic)
        $user = User::find($student->user_id);
        $upload = $user ? DB::table('uploads')->where('id', $user->upload_id)->first() : null;

        //  7️ Filter for current day (e.g., Monday, Tuesday)
        $today = Carbon::now()->format('l'); // Returns 'Monday', 'Tuesday', etc.

        //  Get current time (for time-based filtering)
        $currentTime = Carbon::now()->format('H:i:s'); // 24-hour format e.g. '13:15:00'

        //  8️ Get Upcoming Classes Info (for today's day only)
        $upcomingClasses = DB::table('class_schedules')
            ->whereIn('class_id', $classIds)
            ->where('class_schedules.day', $today) //  Only today's classes
            ->where('class_schedules.start_time', '>', $currentTime) //  Only future classes
            ->join('classes', 'classes.id', '=', 'class_schedules.class_id')
            ->join('staff', 'staff.id', '=', 'classes.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'classes.subject_id')
            ->join('class_rooms', 'class_rooms.id', '=', 'class_schedules.room_id')
            ->select(
                'subjects.name as subject_name',
                'subjects.code as subject_code',
                'staff.first_name',
                'staff.last_name',
                'class_rooms.room_no',
                'class_schedules.start_time',
                'class_schedules.end_time'
            )
            ->orderBy('class_schedules.start_time', 'asc')
            ->get();

        //  9️ Get all session_ids in which this student is enrolled
        $sessionIds = DB::table('session_class_students')
            ->where('student_id', $studentId)
            ->pluck('session_id')
            ->toArray();

        // 10️ Fetch all matching notices
        $notices = DB::table('notice_boards')
            ->where(function ($query) use ($studentId, $classIds, $sessionIds) {
                $query->where('student_id', $studentId)          // specific to student
                    ->orWhereIn('class_id', $classIds)           // based on class
                    ->orWhereIn('session_id', $sessionIds);      // based on session
            })
            ->orderBy('publish_date', 'asc')
            ->take(5) // Sirf 5 latest notices dikhane ke liye
            ->get();

        $query = DB::table('grades')
            ->leftJoin('classes', 'grades.classes_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select(
                'grades.*',
                'classes.name as class_name',
                'subjects.name as subject_name'
            )
            ->where('grades.student_id', $student->id)
            ->orderBy('grades.created_at', 'desc');

        if ($request->filled('school_years_id')) {
            $query->where('grades.school_years_id', $request->school_years_id);
        }

        if ($request->filled('semester_id')) {
            $query->where('grades.semester_id', $request->semester_id);
        }

        $grades = $query->get();
        $query = DB::table('fees_assign_childrens as fac')
            ->leftjoin('fees_masters as fm', 'fm.id', '=', 'fac.fees_master_id')
            ->leftjoin('fees_types as ft', 'ft.id', '=', 'fm.fees_type_id')
            ->select(
                'fac.id as id',
                'ft.name as type',
                'fm.due_date',
                'fm.amount'
            )
            ->where('fac.student_id', $student->id);



        if ($request->filled('year')) {
            $yearName = DB::table('school_years')->where('id', $request->year)->value('name');

            if ($yearName) {
                [$yearStart, $yearEnd] = explode('-', $yearName);
                $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth();
                $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();

                $query->whereBetween('fm.due_date', [$startOfYear, $endOfYear]);
            }
        }

        // $fees = $query->get();
        $perPage = $request->get('perPage', 10);
        $fees = $query->paginate($perPage);
        return view('parent-panel.dashboard', compact('upload', 'student', 'staff', 'upcomingClasses', 'notices', 'first_student', 'grades', 'fees'));

    }

    public function indexupload()
    {
        $students = DB::table('students')
            ->whereNull('parent_guardian_id')
            ->get();

        return view('parent-panel.dashboard-upload', compact('students'));
    }


    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        return view('parent-panel.dashboard', compact('data'));
    }


    public function searchParentMenuData(Request $request)
    {
        try {
            $search = Search::query()
                ->when(request()->filled('search'), fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
                ->where('user_type', 'Parent')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'title' => $item->title,
                        'route_name' => route($item->route_name)
                    ];
                });


            return response()->json($search);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function notices(Request $request)
    {
        $student = Student::where('parent_guardian_id', Auth::id())->first();


        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }


        $studentId = $student->id;


        $classIds = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->pluck('class_id')
            ->toArray();

        $sessionIds = DB::table('session_class_students')
            ->where('student_id', $studentId)
            ->pluck('session_id')
            ->toArray();

        $notices = DB::table('notice_boards')
            ->where(function ($query) use ($studentId, $classIds, $sessionIds) {
                $query->where('student_id', $studentId)          // specific to student
                    ->orWhereIn('class_id', $classIds)           // based on class
                    ->orWhereIn('session_id', $sessionIds);      // based on session
            })
            ->orderBy('publish_date', 'desc')
            ->get();


        $selectedNoticeId = $request->query('notice_id');
        return view('parent-panel.notices', compact('notices', 'selectedNoticeId'));
    }

    
    public function downloadNoticePDF($noticeId)
    {
        // 1. Fetch notice
        $notice = DB::table('notice_boards')->where('id', $noticeId)->first();

        if (!$notice) {
            abort(404, 'Notice not found.');
        }

        // 2. Check if attachment exists
        if (empty($notice->attachment)) {
            return redirect()->back()->with('error', 'No attachment available for this notice.');
        }

        // 3. Fetch upload record (attachment = upload_table.id)
        $upload = DB::table('uploads')->where('id', $notice->attachment)->first();

        if (!$upload) {
            return redirect()->back()->with('error', 'Attachment not found in upload records.');
        }

        // 4. Generate file path
        // Upload path stored example: backend/uploads/users/xxxx.png
        // File is inside storage/app/
        $filePath = $upload->path;

        // 5. Check if file exists on disk
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Attachment file not found on server.');
        }

        // 6. Download file
        return response()->download($filePath, basename($upload->path));
    }


    public function selectStudent(Request $request)
    {
        // Save to session
        session(['selected_student_id' => $request->student_id]);

        return response()->json([
            'success' => true,
            'selected_student_id' => $request->student_id
        ]);
    }
    
}
