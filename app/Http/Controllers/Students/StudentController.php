<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcript;
use App\Models\StudentInfo\Student;
use App\Models\SchoolList;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Examination\Grade;
use App\Models\Attendance\Apply_Leave;
use App\Models\Academic\StudyMaterial;
use App\Models\Attendance\LateCurfew;
use App\Models\Leave;
use Carbon\Carbon;
use DB;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

// use App\Models\Examination\Grade;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NoticeBoard;





class StudentController extends Controller
{
    private function generateOTP()
    {
        return random_int(10000, 99999);
    }

    protected function ShareOtpMail($email, $otp)
    {
        if (empty($email)) {
            \Log::error("Acknowledgement email not sent: missing recipient email.");
            return;
        }

        Mail::send('email.email_otp', compact('email', 'otp'), function ($msg) use ($email) {
            $msg->to($email);
            // $msg->cc('yesitlabs.rahulkumarphp@gmail.com');
            $msg->subject('OTP Email');
        });
    }

    public function studentLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login credentials']);
    }

    public function forgetPassword(Request $request)
    {
        return view('student.forget_password');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No account found with this email.'], 404);
        }

        $otp = $this->generateOTP();

        // store email + otp in session
        session()->put('email', $email);
        session()->put('otp', $otp);

        // send otp mail
        $this->ShareOtpMail($email, $otp);

        return response()->json(['status' => 'success', 'message' => 'OTP sent successfully. Please check your email.']);
    }

    public function resendOTP(Request $request)
    {
        $email = session()->get('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }

        $otp = $this->generateOTP();

        // store otp in session
        session()->put('otp', $otp);

        // send otp mail
        $this->ShareOtpMail($email, $otp);

        return response()->json(['status' => 'success', 'message' => 'OTP resent successfully. Please check your email.']);
    }

    public function verifyOTP(Request $request)
    {
        return view('student.verify_otp');
    }

    public function otpVerification(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // Merge the array into one OTP string
        $enteredOtp = implode('', $request->otp);

        $email = session()->get('email');
        $otp = session()->get('otp');

        if ($enteredOtp == $otp) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'User not found.']);
            }

            $user->reset_password_otp = $otp;
            $user->save();

            session()->forget('otp');

            return redirect()->route('student.update_password_view');
        }

        // If OTP does not match
        return redirect()->back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function updatePasswordView(Request $request)
    {
        return view('student.update_password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Case 1: User is logged in
        if (Auth::check()) {
            $user = Auth::user();
        }

        // Case 2: User is not logged in (forgot password flow, email is in session)
        else {
            $email = session()->get('email');
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Password updated successfully.']);
    }
    public function passwordUpdateLogin(Request $request)
    {
        if (!Auth::check()) {
            $email = session()->get('email');
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'User not found.']);
            }

            Auth::login($user);

            session()->forget('email');
        }

        return redirect()->route('student.dashboard')->with('success', 'Password updated successfully.');
    }



    // public function studentDashboard()
    // {
    //     $student = Student::where('user_id', Auth::id())->first();

    //     if (!$student) {
    //         return redirect()->back()->withErrors(['error' => 'Student not found.']);
    //     }

    //     $staff = DB::table('staff')->get();

    //     $user = User::find($student->user_id);
    //     $upload = $user ? DB::table('uploads')->where('id', $user->upload_id)->first() : null;
    //     return view('student.dashboard', compact('upload', 'student', 'staff'));
    // }

    public function studentDashboard()
    {
        // dd(now());
        // 1️ Get current logged-in student's record
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        // 2️ Get student_id
        $studentId = $student->id;

        // 3️ Get all class_ids for this student
        $classIds = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->pluck('class_id')
            ->toArray();

        if (empty($classIds)) {
            return redirect()->back()->withErrors(['error' => 'No class mapping found for this student.']);
        }

        // 4️ Get all teacher_ids from classes table for those classes
        $teacherIds = DB::table('classes')
            ->whereIn('id', $classIds)
            ->pluck('teacher_id')
            ->filter() // remove nulls
            ->unique()
            ->toArray();

        if (empty($teacherIds)) {
            return redirect()->back()->withErrors(['error' => 'No teachers found for the assigned classes.']);
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
                'staff.upload_id',
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
        // dd($upcomingClasses);
        //  Send all data to view
        // return view('student.dashboard', compact('upload', 'student', 'staff', 'upcomingClasses'));
        return view('student.dashboard', compact('upload', 'student', 'staff', 'upcomingClasses', 'notices'));
        //  Send all data to view
        // return view('student.dashboard', compact('upload', 'student', 'staff'));
    }


    public function studentProfile()
    {
        $data = DB::table('students')
            ->leftjoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('uploads', 'users.upload_id', '=', 'uploads.id')
            ->leftJoin('parent_guardians', 'parent_guardians.student_id', '=', 'students.id')
            ->select('students.*', 'users.name as user_name', 'users.email', 'uploads.path as image_path', 'parent_guardians.*')
            ->where('students.user_id', Auth::id())
            ->first();
        // dd($data);
        if (!$data) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        return view('student.profile', compact('data'));
    }


    // public function studentClasses(Request $request)
    // {

    //     // dd($request->all());
    //     $student = Student::where('user_id', Auth::user()->id)->first();
    //     $studentId = $student->id;

    //     // Get all mappings of this student (class + teachers)
    //     $classDetails = DB::table('student_class_mapping')
    //         ->where('student_id', $studentId)
    //         ->get();

    //     // Extract class_id (assuming all mappings are for the same class)
    //     $classId = $classDetails->first()->class_id ?? null;

    //     // Extract all teacher IDs from mapping
    //     $teacherIds = $classDetails->pluck('teacher_id')->toArray();
    //     $data = DB::table('daily_class_routines')
    //         ->join('subjects', 'daily_class_routines.subject_id', '=', 'subjects.id')
    //         ->join('staff', 'daily_class_routines.teacher_id', '=', 'staff.id')
    //         ->where('daily_class_routines.class_id', $classId)
    //         ->whereIn('daily_class_routines.teacher_id', $teacherIds)
    //         ->select(
    //             'daily_class_routines.*',
    //             'subjects.name as subject_name',
    //             'staff.first_name as staff_first_name',
    //             'staff.last_name as staff_last_name'
    //         )
    //         ->get();

    //     // Create a "time range" column like "10:00 AM - 11:00 AM"
    //     foreach ($data as $item) {
    //         $item->time_range = $item->start_time . ' - ' . $item->end_time;
    //     }
    //     $times = $data->pluck('time_range')->unique()->values();

    //     $times = $times->sortBy(function ($time) {
    //         [$start, $end] = explode(' - ', $time);
    //         return strtotime(str_replace('-', ':', $start));
    //     })->values();

    //     $grouped = [];
    //     foreach ($data as $item) {
    //         $grouped[$item->day][$item->time_range] = $item;
    //     }

    //     $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    //     return view('student.classes', compact('grouped', 'times', 'weekDays'));
    // }


    public function studentClasses(Request $request)
    {
        // dd($request->all());
        $student = Student::where('user_id', Auth::user()->id)->first();
        $studentId = $student->id;

        // Get all mappings of this student (class + teachers)
        $classDetails = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->get();

        // Extract class_id (assuming all mappings are for the same class)
        $classId = $classDetails->first()->class_id ?? null;

        // Extract all teacher IDs from mapping
        $teacherIds = $classDetails->pluck('teacher_id')->toArray();

        // Build the base query
        $query = DB::table('daily_class_routines')
            ->join('subjects', 'daily_class_routines.subject_id', '=', 'subjects.id')
            ->join('staff', 'daily_class_routines.teacher_id', '=', 'staff.id')
            ->where('daily_class_routines.class_id', $classId)
            ->whereIn('daily_class_routines.teacher_id', $teacherIds);

        // =========== ADD DATE FILTERING LOGIC ===========
        // For weekly schedules, we typically don't filter by date in the database
        // because routines repeat weekly. Instead, we might filter by academic year/term
        $selectedDates = $request->dates ?? '';

        if ($request->has('dates') && !empty($request->dates)) {
            $dates = explode(' - ', $request->dates);

            if (count($dates) == 2) {
                $startDate = date('Y-m-d', strtotime($dates[0]));
                $endDate = date('Y-m-d', strtotime($dates[1]));

                // Since this is a weekly routine, we have a few options:

                // OPTION 1: Filter by academic year/term if you have that relationship
                // Check if your table has academic_year_id or academic_term_id
                // $query->whereHas('academicTerm', function($q) use ($startDate, $endDate) {
                //     $q->where('start_date', '<=', $endDate)
                //       ->where('end_date', '>=', $startDate);
                // });

                // OPTION 2: If you have is_active or status field
                // $query->where('daily_class_routines.is_active', 1);

                // OPTION 3: For now, let's REMOVE the date filter entirely for testing
                // Remove or comment out this line:
                // $query->whereBetween('daily_class_routines.created_at', [$startDate, $endDate]);

                // Instead, let's just pass the dates to view if needed
                // But don't filter the routine data
            }
        }
        // =========== END DATE FILTERING LOGIC ===========

        // Execute the query
        $data = $query->select(
            'daily_class_routines.*',
            'subjects.name as subject_name',
            'staff.first_name as staff_first_name',
            'staff.last_name as staff_last_name'
        )
            ->get();

        // Debug: Check if we're getting data
        // dd($data);

        // Create a "time range" column like "10:00 AM - 11:00 AM"
        foreach ($data as $item) {
            $item->time_range = $item->start_time . ' - ' . $item->end_time;
        }
        $times = $data->pluck('time_range')->unique()->values();

        $times = $times->sortBy(function ($time) {
            [$start, $end] = explode(' - ', $time);
            return strtotime(str_replace('-', ':', $start));
        })->values();

        $grouped = [];
        foreach ($data as $item) {
            $grouped[$item->day][$item->time_range] = $item;
        }

        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Shabbos '];

        // Pass the selected dates back to the view
        $selectedDates = $request->dates ?? '';

        return view('student.classes', compact('grouped', 'times', 'weekDays', 'selectedDates'));
    }








    

    // public function studentAssignment()
    // {
    //     $user = Auth::user();
    //     $student = DB::table('students')->where('user_id', $user->id)->first();

    //     $assignments = DB::table('assignments')
    //         ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
    //         ->select(
    //             'assignments.*',
    //             'subjects.name as subject_name'
    //         )
    //         ->orderBy('assignments.assigned_date', 'desc')
    //         ->get();

    //     $assignmentIds = $assignments->pluck('id');

    //     // ✅ Fetch media with timestamps and file sizes
    //     $media = DB::table('assignment_media')
    //         ->whereIn('assignment_id', $assignmentIds)
    //         ->where('student_id', $student->id)
    //         ->select('assignment_id', 'file_name', 'path', 'media_type', 'created_at', 'updated_at')
    //         ->get()
    //         ->map(function ($item) {
    //             $fullPath = public_path($item->path);
    //             if (file_exists($fullPath)) {
    //                 $item->size = $this->formatFileSize(filesize($fullPath)); // human readable size
    //             } else {
    //                 $item->size = 'N/A';
    //             }
    //             return $item;
    //         })
    //         ->groupBy('assignment_id');


    //     $latestMediaUpdates = DB::table('assignment_media')
    //         ->whereIn('assignment_id', $assignmentIds)
    //         ->where('student_id', $student->id)
    //         ->select('assignment_id', DB::raw('MAX(created_at) as last_uploaded'))
    //         ->groupBy('assignment_id')
    //         ->pluck('last_uploaded', 'assignment_id');

    //     $assignments->transform(function ($assignment) use ($media, $latestMediaUpdates) {
    //         $assignment->media = $media->get($assignment->id) ?? collect();
    //         $assignment->last_updated = $latestMediaUpdates[$assignment->id] ?? $assignment->updated_at;
    //         return $assignment;
    //     });

    //     return view('student.assignment', compact('assignments'));
    // }

    /**
     * Convert bytes to human readable size
     */

    public function studentAssignment(Request $request)
    {
        $user = Auth::user();
        $student = DB::table('students')->where('user_id', $user->id)->first();

        // ⭐ Get per-page values (default 5)
        // $pendingPerPage = $request->pending_per_page ?? 5;
        // $completedPerPage = $request->completed_per_page ?? 5;

        // Active Tab – default = pending
        $tab = $request->get('tab', 'pending');

        // Pending per page
        $pendingPerPage = $request->input('pending_per_page', 5);

        // Completed per page
        $completedPerPage = $request->input('completed_per_page', 5);

        // ⭐ PENDING ASSIGNMENTS
        $pending = DB::table('assignments')
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->whereNull('assignments.grade')
            ->select('assignments.*', 'subjects.name as subject_name')
            ->orderBy('assignments.assigned_date', 'desc')
            // ->paginate(5, ['*'], 'pending_page');
            ->paginate($pendingPerPage, ['*'], 'pending_page');

        // ⭐ COMPLETED ASSIGNMENTS
        $completed = DB::table('assignments')
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->whereNotNull('assignments.grade')
            ->select('assignments.*', 'subjects.name as subject_name')
            ->orderBy('assignments.assigned_date', 'desc')
            // ->paginate(5, ['*'], 'completed_page');
            ->paginate($completedPerPage, ['*'], 'completed_page');

        // ⭐ Collect IDs
        $assignmentIds = $pending->pluck('id')->merge($completed->pluck('id'));

        // ⭐ Fetch uploaded media + file size
        $media = DB::table('assignment_media')
            ->whereIn('assignment_id', $assignmentIds)
            ->where('student_id', $student->id)
            ->get()
            ->map(function ($item) {
                $fullPath = public_path($item->path);

                if (file_exists($fullPath)) {
                    $item->size = $this->formatFileSize(filesize($fullPath));
                } else {
                    $item->size = 'N/A';
                }

                return $item;
            })
            ->groupBy('assignment_id');

        // ⭐ Attach media to pending + completed
        foreach ($pending as $item) {
            $item->media = $media[$item->id] ?? collect();
            $item->last_updated = $item->updated_at; // add this
        }

        foreach ($completed as $item) {
            $item->media = $media[$item->id] ?? collect();
            $item->last_updated = $item->updated_at; // add this
        }

        $activeTab = $request->get('tab', 'pending');

        // dd($activeTab);

        return view('student.assignment', compact('pending', 'completed', 'activeTab', 'tab'));
    }
    private function formatFileSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes == 0) return '0 B';
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }




    public function uploadAssignmentFile(Request $request)
    {
        try {
            $request->validate([
                'assignment_id' => 'required|integer',
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp,mp4,mov,doc,docx,xls,xlsx|max:10240',
            ]);

            $userId = Auth::id();

            $student = DB::table('students')->where('user_id', $userId)->first();
            if (!$student) {
                return back()->with('error', 'Student record not found.');
            }

            $mapping = DB::table('student_class_mapping')->where('student_id', $student->id)->first();
            if (!$mapping) {
                return back()->with('error', 'Class mapping not found.');
            }

            $class = DB::table('classes')->where('id', $mapping->class_id)->first();
            if (!$class) {
                return back()->with('error', 'Class not found.');
            }

            $file = $request->file('file');
            if (!$file) {
                return back()->with('error', 'No file received.');
            }

            $destinationPath = public_path('backend/uploads/assignments/images/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $filePath = 'backend/uploads/assignments/images/' . $filename;

            // ✅ 1. Insert into assignment_media
            DB::table('assignment_media')->insert([
                'assignment_id' => $request->assignment_id,
                'student_id' => $student->id,
                'media_type' => $file->getClientOriginalExtension(),
                'file_name' => $filename,
                'path' => $filePath,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ 2. Also update the 'assignment_uploads' column in 'assignments' table
            DB::table('assignments')
                ->where('id', $request->assignment_id)
                ->update([
                    'assignment_uploads' => $filePath,
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'File uploaded successfully!');
        } catch (\Throwable $e) {
            Log::error('Assignment file upload failed', [
                'user_id' => Auth::id(),
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('error', 'File upload failed. Please try again.');
        }
    }

    public function studentAttendance(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $id = $student->id;

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $selectedSubjects = $request->get('subjects', ['all']);

        // Attendance query
        $query = DB::table('attendances')
            ->join('classes', 'attendances.classes_id', '=', 'classes.id')
            ->join('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->where('attendances.student_id', $id)
            ->whereMonth('attendances.date', $month)
            ->whereYear('attendances.date', $year)
            ->select(
                'attendances.date',
                'attendances.attendance',
                'subjects.id as subject_id',
                'subjects.name as subject_name'
            );

        if (!in_array('all', $selectedSubjects)) {
            $query->whereIn('subjects.id', $selectedSubjects);
        }

        $attendances = $query->get();

        // Subject list for filter
        $subjects = DB::table('student_class_mapping')
            ->where('student_id', $id)
            ->leftJoin('classes', 'student_class_mapping.class_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();

        // Map attendance by date + subject_id
        $attendanceData = [];
        foreach ($attendances as $a) {
            $attendanceData[$a->date][$a->subject_id] = match ((int) $a->attendance) {
                1 => 'present',
                2 => 'late',
                3 => 'absent',
                4 => 'half_day',
                default => null,
            };
        }

        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Shabbos'];

        return view('student.attendance', compact(
            'attendances',
            'attendanceData',
            'subjects',
            'selectedSubjects',
            'firstDay',
            'lastDay',
            'month',
            'year',
            'daysOfWeek'
        ));
    }



    public function studentGrades(Request $request)
    {
        $perPage = $request->get('perPage', 5);

        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

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

        $grades = $query->paginate($perPage);

        foreach ($grades as $grade) {
            $classId = $grade->classes_id;
            $studentId = $student->id;

            $attendanceSummary = DB::table('attendances')
                ->select(
                    DB::raw("SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) as total_present"),
                    DB::raw("SUM(CASE WHEN attendance = 2 THEN 1 ELSE 0 END) as total_late"),
                    DB::raw("SUM(CASE WHEN attendance = 3 THEN 1 ELSE 0 END) as total_absent"),
                    DB::raw("SUM(CASE WHEN attendance = 4 THEN 1 ELSE 0 END) as total_halfday")
                )
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->first();

            $approvedLeaves = DB::table('leaves')
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->where('is_approved', 1)
                ->get();

            $approvedLeaveDays = 0;
            foreach ($approvedLeaves as $leave) {
                $days = \Carbon\Carbon::parse($leave->from_date)->diffInDays(\Carbon\Carbon::parse($leave->to_date)) + 1;
                $approvedLeaveDays += $days;
            }

            $points = 0;
            // $points += ($attendanceSummary->total_present ?? 0) * 1;  
            $points += ($attendanceSummary->total_late ?? 0) * 2;
            $points += ($attendanceSummary->total_halfday ?? 0) * 4;
            $points += ($attendanceSummary->total_absent ?? 0) * 6;
            // $points += $approvedLeaveDays * 1;

            $marksGrade = DB::table('marks_grades')
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->value('point');

            $calculatedPoints = ($marksGrade ?? 0) - $points;

            $percentage = 0;
            $percentage = round(($calculatedPoints / 100) * 100, 2);

            $result = $percentage < 59 ? 'Fail' : 'Pass';



            $grade->attendance_summary = [
                'present' => $attendanceSummary->total_present ?? 0,
                'late' => $attendanceSummary->total_late ?? 0,
                'absent' => $attendanceSummary->total_absent ?? 0,
                'half_day' => $attendanceSummary->total_halfday ?? 0,
                'approved_leave_days' => $approvedLeaveDays,
                'attendance_points' => $points,
                'marks_points' => $marksGrade ?? 0,
                'final_points' => $calculatedPoints,
                'percentage' => $percentage,
                'result' => $result,
            ];
        }

        // dd($grades);

        return view('student.grades', [
            'grades' => $grades,
            'yearOptions' => DB::table('school_years')->pluck('name', 'id')->toArray(),
            'semesterOptions' => DB::table('semesters')->pluck('name', 'id')->toArray(),
            'selectedYear' => $request->school_years_id,
            'selectedSemester' => $request->semester_id,
            'perPage' => $perPage,
        ]);
    }




    // public function studentFees()
    // {
    //     $yearOptions = DB::table('school_years')
    //         ->pluck('name', 'id')
    //         ->toArray();


    //     return view('student.fees', [
    //         'yearOptions' => $yearOptions
    //     ]);
    // }

    public function studentFees(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->first();


        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }
        $yearOptions = DB::table('school_years')
            ->pluck('name', 'id')
            ->toArray();

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

        $perPage = $request->get('perPage', 2);
        $fees = $query->paginate($perPage);

        $destinations = SchoolList::getDestination();
        return view('student.fees', [
            'yearOptions' => $yearOptions,
            'fees' => $fees,
            'selectedYear' => $request->year,
            'perPage' => $perPage,
            'destinations' => $destinations
        ]);
    }



    public function storePaymentMyFee(Request $request)
    {
        $request->validate([
            'amount'       => 'required',
            'billing_card'      => 'required',
            'exp_date'          => 'required',
            'security_code'     => 'required',
            'card_holder_name'  => 'required',
            'id'  => 'required'
        ]);

        // dd("AAAAAAAAAA");

        $xKey = "yesitlabsdev8487f53129e34ed48f612f876da78bba";
        $user_id = Auth::id();
        $email = Auth::user()->email;

        // -----------------------------
        // FORMAT EXPIRY DATE → MMYY
        // -----------------------------
        $expDate = str_replace('/', '-', $request->exp_date);
        $parts   = explode('-', $expDate);

        $month = '';
        $year  = '';

        if (count($parts) >= 2) {

            // YYYY-MM
            if (strlen($parts[0]) == 4) {
                $year = substr($parts[0], -2);
                $month = $parts[1];
            }
            // MM-YYYY
            elseif (strlen($parts[1]) == 4) {
                $month = $parts[0];
                $year = substr($parts[1], -2);
            }
        }

        // Fix: ensure leading zero
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $exp   = $month . $year;

        // -----------------------------
        // PAYMENT DATA
        // -----------------------------
        $paymentData = [
            "xKey" => $xKey,
            "xVersion" => "5.0.0",
            "xSoftwareName" => "School ERP",
            "xSoftwareVersion" => "1.0",
            "xCommand" => "cc:sale",
            "xAmount" => $request->amount,
            "xInvoice" => "INV-" . time(),
            "xCardNum" => preg_replace('/\s+/', '', $request->billing_card),
            "xExp" => $exp,
            "xCVV" => $request->security_code,
            "xName" => $request->card_holder_name,
            "xEmail" => $email,   // from logged-in user
            "xAllowDuplicate" => "true",
        ];

        // dd($paymentData);

        $response = Http::asForm()->timeout(45)->post(
            'https://x1.cardknox.com/gateway', // FIXED URL
            $paymentData
        );

        // dd($response);


        if ($response->failed()) {
            dd("AAA");
            return back()->with('error', 'Payment gateway request failed: ' . $response->body());
        }

        parse_str($response->body(), $paymentResult);

        dd($paymentResult['xError']);

        if (($paymentResult['xStatus'] ?? '') !== 'Approved') {
            return back()->with('error', ($paymentResult['xError'] ?? 'Payment failed.'));
        }


        dd($$paymentResult['xStatus']);
        $payment_trans = DB::table('payment_transactions')->insertGetId([
            'transaction_id' => $paymentResult['xRefNum'] ?? null,
            'amount' => $paymentResult['xAmount'] ?? $paymentData['xAmount'],
            'status' => $paymentResult['xStatus'] ?? 'Unknown',
            'auth_code' => $paymentResult['xAuthCode'] ?? null,
            'card_last4' => substr($request->billing_card, -4),
            // 'destination' => $request->destination,
            'response_raw' => json_encode($paymentResult),
            'type' => "student_my_fee",
            'student_id' => $user_id,
            'fees_assign_childrens_id' => $request->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        dd($payment_trans);

        // Transcript::create([
        //     'student_id' => Auth::id(),
        //     'destination' => $request->destination,
        //     'payment_transactions_id' => $payment_trans,
        //     'payment_requirement' => 'Yes',  // default
        // ]);

        return redirect()->route('student.request_transcript');
    }





    // public function studentRequestTranscript(Request $request)
    // {
    //     $destinations = SchoolList::getDestination();
    //     $perPage = $request->get('perPage', 5); // Default items per page
    //     $transcripts = Transcript::where('student_id', Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($perPage);

    //     return view('student.request_transcript', compact('transcripts', 'destinations', 'perPage'));
    // }

    public function studentRequestTranscript(Request $request)
    {
        $destinations = SchoolList::getDestination();
        $perPage = $request->get('perPage', 5);
        $studentId = Auth::id();

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

        // DD($hasTranscripts);

        return view('student.request_transcript', compact('transcripts', 'destinations', 'hasTranscripts', 'perPage'));
    }


    public function storeTranscript(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            // 'payment_receipt_link' => 'nullable',
        ]);

        $transcript = Transcript::create([
            'student_id' => Auth::id(),
            'destination' => $request->destination,
            'payment_requirement' => 'No',  // default
            'payment_status' => 0,          // unpaid
            'status' => 0,                  // pending
        ]);

        return response()->json([
            'success' => true,
            'data' => $transcript
        ]);
    }

    public function storePaymentTranscript(Request $request)
    {
        $request->validate([
            'destination'       => 'required',
            'billing_card'      => 'required',
            'exp_date'          => 'required',
            'security_code'     => 'required',
            'card_holder_name'  => 'required',
        ]);

        // dd("AAAAAAAAAA");

        $xKey = "yesitlabsdev8487f53129e34ed48f612f876da78bba";
        $user_id = Auth::id();
        $email = Auth::user()->email;

        // -----------------------------
        // FORMAT EXPIRY DATE → MMYY
        // -----------------------------
        $expDate = str_replace('/', '-', $request->exp_date);
        $parts   = explode('-', $expDate);

        $month = '';
        $year  = '';

        if (count($parts) >= 2) {

            // YYYY-MM
            if (strlen($parts[0]) == 4) {
                $year = substr($parts[0], -2);
                $month = $parts[1];
            }
            // MM-YYYY
            elseif (strlen($parts[1]) == 4) {
                $month = $parts[0];
                $year = substr($parts[1], -2);
            }
        }

        // Fix: ensure leading zero
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $exp   = $month . $year;

        // -----------------------------
        // PAYMENT DATA
        // -----------------------------
        $paymentData = [
            "xKey" => $xKey,
            "xVersion" => "5.0.0",
            "xSoftwareName" => "School ERP",
            "xSoftwareVersion" => "1.0",
            "xCommand" => "cc:sale",
            "xAmount" => "1.00",
            "xInvoice" => "INV-" . time(),
            "xCardNum" => preg_replace('/\s+/', '', $request->billing_card),
            "xExp" => $exp,
            "xCVV" => $request->security_code,
            "xName" => $request->card_holder_name,
            "xEmail" => $email,   // from logged-in user
            "xAllowDuplicate" => "true",
        ];

        // dd($paymentData);

        $response = Http::asForm()->timeout(45)->post(
            'https://x1.cardknox.com/gateway', // FIXED URL
            $paymentData
        );

        // dd($response);


        if ($response->failed()) {
            return back()->with('error', 'Payment gateway request failed: ' . $response->body());
        }

        parse_str($response->body(), $paymentResult);

        // dd($$paymentResult['xError']);

        if (($paymentResult['xStatus'] ?? '') !== 'Approved') {
            return back()->with('error', ($paymentResult['xError'] ?? 'Payment failed.'));
        }

        $payment_trans = DB::table('payment_transactions')->insertGetId([
            'transaction_id' => $paymentResult['xRefNum'] ?? null,
            'amount' => $paymentResult['xAmount'] ?? $paymentData['xAmount'],
            'status' => $paymentResult['xStatus'] ?? 'Unknown',
            'auth_code' => $paymentResult['xAuthCode'] ?? null,
            'card_last4' => substr($request->billing_card, -4),
            // 'destination' => $request->destination,
            'response_raw' => json_encode($paymentResult),
            'type' => "student_request_transcript",
            'student_id' => $user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Transcript::create([
            'student_id' => Auth::id(),
            'destination' => $request->destination,
            'payment_transactions_id' => $payment_trans,
            'payment_requirement' => 'Yes',  // default
        ]);

        return redirect()->route('student.request_transcript');
    }

    public function downloadPayment($transcriptId)
    {
        $transcript = DB::table('transcripts')
            ->leftJoin('payment_transactions', 'transcripts.payment_transactions_id', '=', 'payment_transactions.id')
            ->where('transcripts.id', $transcriptId)
            ->select(
                'transcripts.id as transcript_id',
                'transcripts.student_id',
                'transcripts.destination',
                'payment_transactions.transaction_id',
                'payment_transactions.amount',
                'payment_transactions.status',
                'payment_transactions.auth_code',
                'payment_transactions.card_last4',
                'payment_transactions.type',
                'payment_transactions.created_at as payment_date'
            )
            ->first();

        if (!$transcript) {
            return back()->with('error', 'No payment record found.');
        }

        $filename = 'payment_transcript_' . $transcript->transcript_id . '.csv';

        $columns = array_keys((array)$transcript);

        $callback = function () use ($transcript, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // header
            fputcsv($file, (array)$transcript); // row
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }




    // Apply leave--------------------------------------------------------------------------

    public function studentApplyLeave(Request $request)
    {
        $perPage = $request->get('perPage', 4);

        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $yearOptions = DB::table('school_years')->pluck('name', 'id')->toArray();
        $semesteroptions = DB::table('semesters')->pluck('name', 'id')->toArray();

        $query = Leave::where('student_id', $student->id)
            ->orderBy('created_at', 'desc');

        if ($request->filled('year')) {
            $yearName = DB::table('school_years')->where('id', $request->year)->value('name');
            if ($yearName) {
                [$yearStart, $yearEnd] = explode('-', $yearName);
                $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth();
                $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();
                $query->whereBetween('from_date', [$startOfYear, $endOfYear]);
            }
        }

        if ($request->filled('semester')) {
            $query->where('semester_id', $request->semester);
        }


        $leaves = $query->paginate($perPage);

        return view('student.apply_leave', [
            'leaves' => $leaves,
            'perPage' => $perPage,
            'yearOptions' => $yearOptions,
            'semesteroptions' => $semesteroptions
        ]);
    }




    public function storeLeave(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date|after_or_equal:today',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'reason'    => 'nullable|string',
        ]);

        $student = Student::where('user_id', Auth::id())->first();
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $overlap = Leave::where('student_id', $student->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('from_date', [$request->from_date, $request->to_date])
                    ->orWhereBetween('to_date', [$request->from_date, $request->to_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('from_date', '<=', $request->from_date)
                            ->where('to_date', '>=', $request->to_date);
                    });
            })->exists();

        if ($overlap) {
            return redirect()
                ->back()
                ->withErrors(['overlap' => 'You already have a leave request in this date range.'])
                ->withInput();
        }

        Leave::create([
            'student_id' => $student->id,
            'from_date'  => $request->from_date,
            'to_date'    => $request->to_date,
            'reason'     => $request->reason,
            'is_approved'     => 0,
            'apply_date' => now(),
        ]);

        return redirect()
            ->route('student.apply_leave')
            ->with('success', 'Leave request submitted successfully.');
    }



    public function editLeave($id)
    {
        $leave = Leave::findOrFail($id);
        return response()->json($leave);
    }


    public function updateLeave(Request $request, $id)
    {
        $request->validate([
            'from_date' => 'required|date|after_or_equal:today',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'reason'    => 'nullable|string',
        ]);

        $student = Student::where('user_id', Auth::id())->first();
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $leave = Leave::where('student_id', $student->id)->findOrFail($id);

        $overlap = Leave::where('student_id', $student->id)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('from_date', [$request->from_date, $request->to_date])
                    ->orWhereBetween('to_date', [$request->from_date, $request->to_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('from_date', '<=', $request->from_date)
                            ->where('to_date', '>=', $request->to_date);
                    });
            })->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'You already have a leave request in this date range.'])->withInput();
        }

        $leave->update([
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
            'reason'    => $request->reason,
        ]);

        return redirect()->route('student.apply_leave')->with('success', 'Leave request updated successfully.');
    }
    public function deleteLeave($id)
    {
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $leave = Leave::where('student_id', $student->id)->findOrFail($id);
        $leave->delete();

        return redirect()->route('student.apply_leave')->with('success', 'Leave request deleted successfully.');
    }

    public function studentNoticeBoard(Request $request)
    {

        $student = Student::where('user_id', Auth::id())->first();


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


        return view('student.notice_board', compact('notices', 'selectedNoticeId'));
    }

    public function downloadNoticePDF($id)
    {
        $notice = NoticeBoard::findOrFail($id);

        $pdf = Pdf::loadView('student.notice_pdf', compact('notice'));

        $fileName = 'Notice_' . str_replace(' ', '_', $notice->title) . '.pdf';
        return $pdf->download($fileName);
    }

    public function studentStudyMaterial(Request $request)
    {

        $perPage = $request->get('perPage', 4);

        $materials = StudyMaterial::orderBy('subject')->paginate($perPage);

        return view('student.study_material', [
            'materials' => $materials,
            'perPage' => $perPage
        ]);
    }



    // late curfew request----------------------------------------------------------------------

    public function studentLateCurfewRequest(Request $request)
    {

        // dd($request->all());
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $startDate = null;
        $endDate = null;

        if ($request->filled('dates')) {
            $dates = explode(' - ', $request->dates);

            try {
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                $endDate   = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');
            } catch (\Exception $e) {
                $startDate = $endDate = null;
            }
        }

        $yearOptions = DB::table('school_years')->pluck('name', 'id')->toArray();

        $query = LateCurfew::where('student_id', $student->id)
            ->where('status', 'pending')
            ->orderBy('date', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($request->filled('year')) {
            $yearName = DB::table('school_years')->where('id', $request->year)->value('name');
            if ($yearName) {
                [$yearStart, $yearEnd] = explode('-', $yearName);

                $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth(); // e.g. 2024-06-01
                $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();   // e.g. 2025-05-31

                $query->whereBetween('date', [$startOfYear, $endOfYear]);
            }
        }

        $requested = $query->paginate(5, ['*'], 'requested_page');

        $query2 = LateCurfew::where('student_id', $student->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('date', 'desc');

        if ($startDate && $endDate) {
            $query2->whereBetween('date', [$startDate, $endDate]);
        }

        if ($request->filled('year')) {
            $yearName = DB::table('school_years')->where('id', $request->year)->value('name');
            if ($yearName) {
                [$yearStart, $yearEnd] = explode('-', $yearName);

                $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth();
                $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();

                $query2->whereBetween('date', [$startOfYear, $endOfYear]);
            }
        }

        $final = $query2->paginate(5, ['*'], 'final_page');



        $tab = $request->tab ?? 'requested'; // default tab is requested

        if ($request->ajax()) {
            if ($request->tab === 'requested') {
                return view('student.particals.requested', compact('requested'))->render();
            }

            if ($request->tab === 'final') {
                return view('student.particals.final', compact('final'))->render();
            }
        }



        // dd([
        //     'requested'=>$requested, 
        //     'final'=>$final
        // ]);
        return view('student.late_curfew_request', compact('requested', 'final', 'yearOptions', 'tab'))->with('tab', $tab);
    }


    public function storeLateCurfew(Request $request)
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'time'   => 'required',
            'room'   => 'required|string|max:50',
            'reason' => 'nullable|string',
        ]);

        $student = Student::where('user_id', Auth::id())->firstOrFail();

        LateCurfew::create([
            'student_id' => $student->id,
            'date'       => $request->date,
            'time'       => $request->time,
            'room'       => $request->room,
            'reason'     => $request->reason,
            'status'     => 'pending',
        ]);

        return redirect()->route('student.late_curfew_request')
            ->with('success', 'Late curfew request submitted successfully.');
    }

    public function editLateCurfew($id)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $request = LateCurfew::where('student_id', $student->id)->findOrFail($id);

        return response()->json($request);
    }


    public function updateLateCurfew(Request $request, $id)
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'time'   => 'required',
            'room'   => 'required|string|max:50',
            'reason' => 'nullable|string',
        ]);

        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $lateCurfew = LateCurfew::where('student_id', $student->id)->findOrFail($id);

        $lateCurfew->update([
            'date'   => $request->date,
            'time'   => $request->time,
            'room'   => $request->room,
            'reason' => $request->reason,
        ]);

        return redirect()->route('student.late_curfew_request')
            ->with('success', 'Request updated successfully.');
    }


    public function deleteLateCurfew($id)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $lateCurfew = LateCurfew::where('student_id', $student->id)->findOrFail($id);
        $lateCurfew->delete();

        return redirect()->route('student.late_curfew_request')
            ->with('success', 'Request deleted successfully.');
    }


    public function studentLogout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
