<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ScheduleTrait; 
use App\Models\StudentClassMapping;
use Illuminate\Support\Facades\{Auth,Log,DB};
use App\Models\Academic\Subject;
use App\Models\Attendance\Attendance;
use App\Models\Leave;
use Carbon\Carbon;


class DashboardController extends Controller
{
    use ScheduleTrait;

    public function index(Request $request)
    {
        $teacherId = Auth::user()->staff->id;
        $selectedDate = $request->get('date', date('Y-m-d'));

        // dd($today);

        $daySchedule = $this->getSchedulesForDate($selectedDate, $teacherId);
        $weekSchedule = $this->getSchedulesForWeek($selectedDate, $teacherId);
        $monthSchedule = $this->getSchedulesForMonth($selectedDate, $teacherId);
        
        $periods = DB::table('period')
                    ->where('start_time', '>=', '08:00:00')
                    ->where('end_time', '<=', '17:59:00')
                    ->orderBy('start_time')
                    ->get();

        return view('staff.dashboard', [
            'totalStudent'  => $this->getTotalStudents(),
            'subjects'      => $this->getTeachersubject(),
            'rooms'         => $this->getTeacherRooms(),
            'daySchedule'   => $daySchedule,    
            'weekSchedule'  => $weekSchedule,   
            'monthSchedule' => $monthSchedule, 
            'periods'       => $periods,        
            'selectedDate'  => $selectedDate,
            'viewType'      => 'dashboard' ,
            'totalStudent'          => $this->getTotalStudents(),
            'todayAttendance'       => $this->getTodayStudentAttendance(),
           
        ]);
    }
 
    private function getTotalStudents()
    {
        $teacherId = Auth::user()->staff->id;
        // dd($teacherId);
 
        return StudentClassMapping::where('teacher_id', $teacherId)
            ->distinct('student_id')
            ->count('student_id');
    }


    private function getTodayStudentAttendance()
    {
        $teacherId = Auth::id();
        $today = now()->format('Y-m-d');
        $session = currentSession();

        // dump($session);

        // Step 1: Get all unique student IDs assigned to this teacher
        $studentIds = StudentClassMapping::where('teacher_id', $teacherId)
            ->distinct()
            ->pluck('student_id'); // Collection of student IDs

        $totalStudents = $studentIds->count();

        if ($totalStudents === 0) {
            return [
                'present' => 0, 'absent' => 0, 'late' => 0, 'leave' => 0,
                'present_percent' => 0, 'absent_percent' => 0, 'late_percent' => 0, 'leave_percent' => 0,
            ];
        }

        // Step 2: Get students on approved leave today
        $leaveStudentIds = Leave::where('is_approved', 1)
            ->whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->where('session_id', $session->session_id)
            ->where('year_status_id', $session->year_status_id)
            ->where('semester_id', $session->semester_id)
            ->pluck('student_id');

        $onLeaveCount = $leaveStudentIds->count();

        // Step 3: Get today's attendance records for these students
        $attendanceRecords = Attendance::whereIn('student_id', $studentIds)
            ->where('session_id', $session->session_id)
            ->where('year_status_id', $session->year_status_id)
            ->where('semester_id', $session->semester_id)
            ->whereDate('date', $today)
            ->select('student_id', 'attendance') // 1=present, 2=late, 3=absent
            ->get();

        // Count attendance types
        $present = 0;
        $late    = 0;
        $absent  = 0;

        foreach ($attendanceRecords as $record) {
            if (in_array($record->student_id, $leaveStudentIds->toArray())) {
                continue; // Skip if on approved leave (already counted in leave)
            }

            switch ($record->attendance) {
                case 1:
                    $present++;
                    break;
                case 2:
                    $late++;
                    break;
                case 3:
                    $absent++;
                    break;
            }
        }

        // Step 4: Students with no record today (and not on leave) = Absent
        $recordedStudentIds = $attendanceRecords->pluck('student_id')->merge($leaveStudentIds);
        $notRecordedCount = $studentIds->diff($recordedStudentIds)->count();

        $absent += $notRecordedCount;

        // Final counts
        $counts = [
            'present' => $present,
            'late'    => $late,
            'absent'  => $absent,
            'leave'   => $onLeaveCount,
        ];

        // Calculate percentages
        $counts['present_percent'] = $totalStudents > 0 ? round(($counts['present'] / $totalStudents) * 100, 2) : 0;
        $counts['absent_percent']  = $totalStudents > 0 ? round(($counts['absent'] / $totalStudents) * 100, 2) : 0;
        $counts['late_percent']    = $totalStudents > 0 ? round(($counts['late'] / $totalStudents) * 100, 2) : 0;
        $counts['leave_percent']   = $totalStudents > 0 ? round(($counts['leave'] / $totalStudents) * 100, 2) : 0;

        return $counts;
    }

    public function getTeachersubject()
    {
        $teacherId = Auth::user()->staff->id;
        // dd($teacherId);

        $subjects = Subject::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('staff.id', $teacherId);
        })->get();

        // dd($subjects);

        return $subjects;
    }

    public function getTeacherRooms()
    {
        try {
            $teacherId = Auth::user()->staff->id;
            
            $rooms = DB::table('class_schedules as cs')
                    ->join('classes as c', 'cs.class_id', '=', 'c.id')
                    ->join('class_rooms as r', 'cs.room_id', '=', 'r.id') 
                    ->where('c.teacher_id', $teacherId)
                    ->whereNull('cs.deleted_at')
                    ->select(
                        'r.id as room_id',
                        'r.room_no as room_number',
                        'r.capacity',
                        DB::raw("'schedule' as source")
                    )
                    ->distinct()
                    ->get();

            // dd($rooms);
                
            return $rooms;
            
        } catch (\Exception $e) {
            Log::error('Error fetching teacher rooms: ' . $e->getMessage());
            return collect([]);
        }
    }
   

    
  
}



