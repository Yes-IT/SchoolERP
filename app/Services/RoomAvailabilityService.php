<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomAvailabilityService
{
    /**
     * Check if room is available for a specific date & time.
     * Returns TRUE = available, FALSE = not available
     */
    public function isRoomAvailable($roomId, $date, $startTime, $endTime)
    {
        // -------- CHECK EXAM SCHEDULES --------
        $examConflict = DB::table('exam_schedules')
            ->where('room_id', $roomId)
            ->whereDate('exam_date', $date)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q2) use ($startTime, $endTime) {
                        $q2->where('start_time', '<=', $startTime)
                           ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($examConflict) {
            return false;
        }

        // -------- CHECK CLASS SCHEDULES --------
        $day = strtolower(date('l', strtotime($date)));

        $classConflict = DB::table('class_schedules')
            ->where('room_id', $roomId)
            ->where('day', $day)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q2) use ($startTime, $endTime) {
                        $q2->where('start_time', '<=', $startTime)
                           ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($classConflict) {
            return false;
        }

        return true; // No conflict found
    }

    /**
     * Get all dates of a weekday inside a specific month.
     * Example: get all Mondays in December 2025
     */
    public function getAllWeekdayDates($weekday, $month, $year)
    {
        $dates = [];

        $date = Carbon::create($year, $month, 1);

        // Move to first matching weekday
        while ($date->format('l') !== $weekday) {
            $date->addDay();
        }

        // Loop through all weeks
        while ($date->month == $month) {
            $dates[] = $date->toDateString();
            $date->addWeek();
        }

        return $dates;
    }

    /**
     * Check all weekday dates in a month and return the unavailable ones.
     */
    public function getUnavailableDatesForWeekday($roomId, $weekday, $month, $year, $start, $end)
    {
        $dates = $this->getAllWeekdayDates($weekday, $month, $year);

        $unavailable = [];

        foreach ($dates as $date) {
            if (!$this->isRoomAvailable($roomId, $date, $start, $end)) {
                $unavailable[] = $date;
            }
        }

        return $unavailable;
    }

    /**
     * Mark all weekday dates as unavailable (OPTIONAL)
     * (insert into your custom availability table)
     */
    public function markDatesUnavailable($roomId, $weekday, $month, $year, $start, $end)
    {
        $dates = $this->getUnavailableDatesForWeekday($roomId, $weekday, $month, $year, $start, $end);

        foreach ($dates as $date) {
            DB::table('room_unavailable_dates')->insert([
                'room_id'    => $roomId,
                'date'       => $date,
                'start_time' => $start,
                'end_time'   => $end,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $dates;
    }
}

