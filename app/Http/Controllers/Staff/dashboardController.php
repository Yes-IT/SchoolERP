<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ScheduleTrait; 
use App\Models\StudentClassMapping;
use Illuminate\Support\Facades\{Auth,Log,DB};
use App\Models\Academic\Subject;


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
            'viewType'      => 'dashboard' 
           
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
