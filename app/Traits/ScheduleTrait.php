<?php

namespace App\Traits;

use Illuminate\Support\Facades\{DB,Log};


trait ScheduleTrait
{
    private function getSchedulesForDate($date, $teacherId)
    {
        $day = date('l', strtotime($date)); 
        
        try {
            // Get TEACHER'S CLASS SCHEDULES for that day
            $classSchedules = DB::table('class_schedules as cs')
                ->join('classes as c', 'cs.class_id', '=', 'c.id')
                ->leftJoin('subjects as s', 'c.subject_id', '=', 's.id')
                ->where('cs.day', $day)
                ->where('c.teacher_id', $teacherId)
                ->whereNull('cs.deleted_at')
                ->select(
                    'cs.*',
                    'c.name as class_name',
                    's.name as subject_name',
                    DB::raw("'class' as type")
                )
                ->orderBy('cs.start_time')
                ->get();
            
            // Get TEACHER'S EXAM SCHEDULES for that date
            $examSchedules = DB::table('exam_schedules as es')
                ->join('exam_requests as er', 'es.exam_request_id', '=', 'er.id')
                ->leftJoin('subjects as s', 'er.subject_id', '=', 's.id')
                ->leftJoin('classes as c', 'er.class_id', '=', 'c.id')
                ->leftJoin('exam_types as et', 'er.exam_type_id', '=', 'et.id')
                ->whereDate('es.exam_date', $date)
                ->where('er.teacher_id', $teacherId)
                ->where('er.status', 'approved')
                ->whereNull('es.deleted_at')
                ->select(
                    'es.*',
                    'er.exam_type_id',
                    'er.teacher_id',
                    's.name as subject_name',
                    'c.name as class_name',
                    'et.name as exam_type_name',
                    DB::raw("'exam' as type")
                )
                ->orderBy('es.start_time')
                ->get();
                
            $allSchedules = $classSchedules->merge($examSchedules);
            
            return [
                'date' => $date,
                'day_name' => $day,
                'class_schedules' => $classSchedules,
                'exam_schedules' => $examSchedules,
                'all_schedules' => $allSchedules
            ];
            
        } catch (\Exception $e) {
            Log::error('Error in getSchedulesForDate: ' . $e->getMessage());
            
            return [
                'date' => $date,
                'day_name' => $day,
                'class_schedules' => collect([]),
                'exam_schedules' => collect([]),
                'all_schedules' => collect([])
            ];
        }
    }

    private function getSchedulesForWeek($date, $teacherId)
    {
        try {
            $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($date)));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($date)));
            
            $weekSchedules = [];
            $currentDate = $startOfWeek;
            
            while (strtotime($currentDate) <= strtotime($endOfWeek)) {
                $dateSchedule = $this->getSchedulesForDate($currentDate, $teacherId);
                $weekSchedules[$currentDate] = $dateSchedule;
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            }
            
            return [
                'week_start' => $startOfWeek,
                'week_end' => $endOfWeek,
                'daily_schedules' => $weekSchedules 
            ];
            
        } catch (\Exception $e) {
            Log::error('Error in getSchedulesForWeek: ' . $e->getMessage());
            return [
                'week_start' => $date,
                'week_end' => $date,
                'daily_schedules' => []
            ];
        }
    }

    private function getSchedulesForMonth($date, $teacherId)
    {
        try {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            
            $monthSchedules = [];
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = date('Y-m-d', strtotime("{$year}-{$month}-{$day}"));
                $monthSchedules[$currentDate] = $this->getSchedulesForDate($currentDate, $teacherId);
            }
            
            return [
                'year' => $year,
                'month' => $month,
                'month_name' => date('F', strtotime($date)),
                'daily_schedules' => $monthSchedules
            ];
            
        } catch (\Exception $e) {
            Log::error('Error in getSchedulesForMonth: ' . $e->getMessage());
            return [
                'year' => date('Y'),
                'month' => date('m'),
                'month_name' => date('F'),
                'daily_schedules' => []
            ];
        }
    }
}