<?php

namespace App\Repositories\Academic;

use App\Interfaces\Academic\RoomManagementRepositoryInterface;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\ClassSchedule;
use App\Models\Examination\ExamSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomManagementRepository implements RoomManagementRepositoryInterface
{
    protected $model;

    public function __construct(ClassRoom $room)
    {
        $this->model = $room;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $room = $this->find($id);
        $room->update($data);
        return $room;
    }

    public function delete($id)
    {
        $room = $this->find($id);
        return $room->delete();
    }

    /* ──────────────────────────────────────
       AVAILABILITY GRID – THE ONLY METHOD YOU NEED
       ────────────────────────────────────── */
    public function getAvailabilityGrid(string $from, string $to): array
    {
        // -------------------------------------------------
        // 1. Date range
        // -------------------------------------------------
        $startDate = Carbon::parse($from)->startOfDay();
        $endDate   = Carbon::parse($to)->endOfDay();

        // -------------------------------------------------
        // 2. DYNAMIC TIME SLOTS (covers 09:00 – 22:00)
        // -------------------------------------------------
        $slotLabels = [];
        $slotStartTimes = [];

        for ($hour = 9; $hour < 22; $hour++) {
            $start = sprintf('%02d:00:00', $hour);
            $end   = sprintf('%02d:00:00', $hour + 1);
            $label = Carbon::createFromFormat('H:i:s', $start)->format('h:i A').'-'.Carbon::createFromFormat('H:i:s', $end)->format('h:i A');

            $slotStartTimes[] = $start;
            $slotLabels[] = $label;
        }

        // -------------------------------------------------
        // 3. All rooms
        // -------------------------------------------------
        $rooms = ClassRoom::select('id', 'room_no','capacity')->orderBy('room_no')->get();
        $roomIds = $rooms->pluck('id');

        // -------------------------------------------------
        // 4. ClassSchedules – grouped by (weekday → room_id)
        // -------------------------------------------------
        $classSchedules = ClassSchedule::whereIn('room_id', $roomIds)
            ->get()
            ->groupBy('day')
            ->map(fn($items) => $items->groupBy('room_id'));

        // -------------------------------------------------
        // 5. ExamSchedules – grouped by (exam_date|room_id)
        // -------------------------------------------------
        $examSchedules = ExamSchedule::whereBetween('exam_date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
            ->whereIn('room_id', $roomIds)
            ->get()
            ->groupBy(fn($e) => $e->exam_date . '|' . $e->room_id);

        // -------------------------------------------------
        // 6. Build the grid: day → [room → [slots]]
        // -------------------------------------------------
        $days = [];
        $cur = $startDate->copy();

        while ($cur->lte($endDate)) {
            $dateStr  = $cur->format('Y-m-d');
            $dayLabel = $cur->format('l, F d');
            $weekday  = $cur->englishDayOfWeek; // Monday, Tuesday...

            // Initialize grid: [room_id => [slot_index => status]]
            $roomGrid = $rooms->mapWithKeys(function ($room) use ($slotStartTimes) {
                return [
                    $room->id => array_fill(0, count($slotStartTimes), [
                        'status' => 'available',
                        'title'  => null,
                        'meta'   => null
                    ])
                ];
            })->toArray();

            // Check each time slot
            foreach ($slotStartTimes as $idx => $slotStartStr) {
                $slotStart = Carbon::createFromFormat('Y-m-d H:i:s', "$dateStr $slotStartStr");
                $slotEnd   = $slotStart->copy()->addHour();

                foreach ($rooms as $room) {
                    $roomId = $room->id;
                    $booked = false;
                    $info = null;

                    // --- CLASS CHECK ---
                    if (isset($classSchedules[$weekday][$roomId])) {
                        foreach ($classSchedules[$weekday][$roomId] as $cls) {
                            if ($this->timesOverlap($cls->start_time, $cls->end_time, $slotStart, $slotEnd)) {
                                $booked = true;
                                $info = [
                                    'title' => "Class #{$cls->class_id}",
                                    'meta'  =>
                                            Carbon::createFromFormat('H:i:s', $cls->start_time)->format('h:i A') .
                                            ' - ' .
                                            Carbon::createFromFormat('H:i:s', $cls->end_time)->format('h:i A')
                                ];
                                break;
                            }
                        }
                    }

                    // --- EXAM CHECK ---
                    $examKey = "$dateStr|{$roomId}";
                    if (!$booked && isset($examSchedules[$examKey])) {
                        foreach ($examSchedules[$examKey] as $exam) {
                            if ($this->timesOverlap($exam->start_time, $exam->end_time, $slotStart, $slotEnd)) {
                                $booked = true;
                                $info = [
                                    'title' => 'Exam',
                                    'meta'  =>
                                            Carbon::createFromFormat('H:i:s', $exam->start_time)->format('h:i A') .
                                            ' - ' .
                                            Carbon::createFromFormat('H:i:s', $exam->end_time)->format('h:i A')
                                ];
                                break;
                            }
                        }
                    }

                    if ($booked) {
                        $roomGrid[$roomId][$idx] = [
                            'status' => 'scheduled',
                            'title'  => $info['title'],
                            'meta'   => $info['meta']
                        ];
                    }
                }
            }

            $days[] = [
                'date'  => $dayLabel,
                'rooms' => $rooms->map(function ($room) use ($roomGrid) {
                    return [
                        'id'      => $room->id,
                        'room_no' => $room->room_no,
                        'capacity' => $room->capacity,
                        'slots'   => $roomGrid[$room->id]
                    ];
                })->values()->all()
            ];

            $cur->addDay();
        }

        return [
            'days'       => $days,
            'time_slots' => $slotLabels
        ];
    }


    // -----------------------------------------------------------------
    //  Helper – works with string (H:i:s) OR Carbon instance
    // -----------------------------------------------------------------
    private function timesOverlap($start, $end, Carbon $slotStart, Carbon $slotEnd): bool
    {
        $toCarbon = function ($time) use ($slotStart) {
            if ($time instanceof Carbon) {
                return $time->copy()->setDate($slotStart->year, $slotStart->month, $slotStart->day);
            }

            if (is_string($time) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
                return Carbon::createFromFormat(
                    'H:i:s',
                    $time,
                    $slotStart->timezone
                )->setDate($slotStart->year, $slotStart->month, $slotStart->day);
            }

            return null;
        };

        $s = $toCarbon($start);
        $e = $toCarbon($end);

        return $s && $e && $s < $slotEnd && $e > $slotStart;
    }

    
}