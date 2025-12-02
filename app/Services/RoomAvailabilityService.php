<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RoomAvailabilityService
{
    /**
     * Check if room is available for given date & time.
     * Returns true = available, false = NOT available.
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
        $day = strtolower(date('l', strtotime($date))); // Convert date → Monday, Tuesday, etc.

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

        // NO CONFLICT FOUND
        return true;
    }
}
