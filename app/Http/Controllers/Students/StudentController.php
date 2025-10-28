<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentInfo\Student;
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



    public function studentDashboard()
    {
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $staff = DB::table('staff')->get();

        $user = User::find($student->user_id);
        $upload = $user ? DB::table('uploads')->where('id', $user->upload_id)->first() : null;
        return view('student.dashboard', compact('upload', 'student', 'staff'));
    }



    public function studentProfile()
    {
        $data = Student::where('user_id', Auth::id())->first();

        if (!$data) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        $user = User::find($data->user_id);
        $upload = $user ? DB::table('uploads')->where('id', $user->upload_id)->first() : null;
        return view('student.profile', compact('data', 'upload'));
    }


    public function studentClasses()
    {
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
        $data = DB::table('daily_class_routines')
            ->join('subjects', 'daily_class_routines.subject_id', '=', 'subjects.id')
            ->join('staff', 'daily_class_routines.teacher_id', '=', 'staff.id')
            ->where('daily_class_routines.class_id', $classId)
            ->whereIn('daily_class_routines.teacher_id', $teacherIds)
            ->select(
                'daily_class_routines.*',
                'subjects.name as subject_name',
                'staff.first_name as staff_first_name',
                'staff.last_name as staff_last_name'
            )
            ->get();

        // Create a "time range" column like "10:00 AM - 11:00 AM"
        foreach ($data as $item) {
            $item->time_range = $item->start_time . ' - ' . $item->end_time;
        }

        // All unique time slots (to display columns)
        $times = $data->pluck('time_range')->unique()->values();

        // Sort by actual time using strtotime
        $times = $times->sortBy(function ($time) {
            [$start, $end] = explode(' - ', $time);
            return strtotime(str_replace('-', ':', $start));
        })->values();

        // Group data by [day][time_range]
        $grouped = [];
        foreach ($data as $item) {
            $grouped[$item->day][$item->time_range] = $item;
        }

        // Define week days in order
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('student.classes', compact('grouped', 'times', 'weekDays'));
    }

    public function studentAssignment()
    {
        $user = Auth::user();
        $student = DB::table('students')->where('user_id', $user->id)->leftJoin('student_class_mapping', 'student_class_mapping.student_id', 'students.id')->first();


        $assignments = DB::table('assignments')->where('class_id', $student->class_id)
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->select(
                'assignments.*',
                'subjects.name as subject_name'
            )
            ->orderBy('assignments.assigned_date', 'desc')
            ->get();
        $completed_assignments = DB::table('assignments')
            ->where('class_id', $student->class_id)
            ->where('student_id', $student->id)
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->select(
                'assignments.*',
                'subjects.name as subject_name'
            )
            ->orderBy('assignments.assigned_date', 'desc')
            ->get()
            ->map(function ($assignment) use ($student) {
                $media = DB::table('assignment_media')
                    ->where('assignment_id', $assignment->id)
                    ->where('student_id', $student->id)
                    ->get();

                $assignment->media = $media;
                return $assignment;
            });

        return view('student.assignment', compact('assignments', 'completed_assignments'));
    }


    public function uploadAssignmentFile(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp,mp4,mov,doc,docx,xls,xlsx|max:10240', // 10MB max
        ]);

        $studentId = Auth::id();
        $file = $request->file('file');

        // Save the file in storage/app/public/assignments
        $filePath = $file->store('assignments', 'public');

        DB::table('assignment_media')->insert([
            'assignment_id' => $request->assignment_id,
            'student_id' => $studentId,
            'subject_id' => $request->subject_id,
            'media_type' => $file->getClientOriginalExtension(),
            'file_name' => $filePath,
            'status' => 1, // active
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'File uploaded successfully!');
    }

    public function studentAttendance(Request $request)
    {
        // Get logged-in student ID
        $student = Student::where('user_id', Auth::user()->id)->first();
        $id = $student->id;

        // Get selected month/year or default to current
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $selectedSubjects = $request->get('subjects', []);

        // Base query for attendance
        $query = DB::table('attendances')
            ->where('student_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)->leftJoin('classes', 'attendances.classes_id', '=', 'classes.id');

        // Filter by subjects (if not "all")
        if (!in_array('all', $selectedSubjects) && !empty($selectedSubjects)) {
            $query->whereIn('classes.subject_id', $selectedSubjects);
        }

        $data = $query->get();

        // Get all subjects for the dropdown
        $subjects = DB::table('student_class_mapping')
            ->where('student_id', $id)
            ->leftJoin('classes', 'student_class_mapping.class_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select('subjects.id', 'subjects.name')
            ->get();

        // Transform DB data
        $attendanceData = $data->mapWithKeys(function ($item) {
            $status = match ($item->roll) {
                'on time', 'present' => 'present',
                'late' => 'late',
                'half_day' => 'half_day',
                'absent' => 'absent',
                default => null,
            };
            return [$item->date => $status];
        })->toArray();

        // Calendar details
        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Shabbos'];

        return view('student.attendance', compact(
            'data',
            'daysOfWeek',
            'firstDay',
            'lastDay',
            'attendanceData',
            'month',
            'year',
            'subjects'
        ));
    }



    public function studentGrades(Request $request)
    {
        $perPage = $request->get('perPage', 5);

        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $yearOptions = DB::table('school_years')
            ->pluck('name', 'id')
            ->toArray();

        $semesterOptions = DB::table('semesters')
            ->pluck('name', 'id')
            ->toArray();

        $query = DB::table('grades')
            ->leftJoin('classes', 'grades.classes_id', '=', 'classes.id')
            ->select(
                'grades.*',
                'classes.name as class_name'
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

        return view('student.grades', [
            'grades' => $grades,
            'selectedYear' => $request->school_years_id,
            'selectedSemester' => $request->semester_id,
            'yearOptions' => $yearOptions,
            'semesterOptions' => $semesterOptions,
            'perPage' => $perPage,
        ]);
    }




    public function studentFees()
    {
        $yearOptions = DB::table('school_years')
            ->pluck('name', 'id')
            ->toArray();


        return view('student.fees', [
            'yearOptions' => $yearOptions
        ]);
    }

    public function studentRequestTranscript()
    {
        return view('student.request_transcript');
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

    public function studentNoticeBoard()
    {
        $student = Student::where('user_id', Auth::id())->first();

        $data = DB::table('notice_boards')
            ->where(function ($query) use ($student) {
                $query->whereNull('class_id')
                    ->orWhereNull('section_id')
                    ->orWhereNull('student_id')
                    ->orWhere('student_id', $student->id);
            })
            ->whereDate('date', '>=', now())
            ->get();

        return view('student.notice_board', compact('data'));
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

        return view('student.late_curfew_request', compact('requested', 'final', 'yearOptions'));
    }


    public function storeLateCurfew(Request $request)
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'time'   => 'required',
            'room'   => 'required|string|max:50',
            'reason' => 'nullable|string|max:500',
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
            'reason' => 'nullable|string|max:500',
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
