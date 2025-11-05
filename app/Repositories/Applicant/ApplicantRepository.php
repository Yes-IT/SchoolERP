<?php

namespace App\Repositories\Applicant;

use App\Interfaces\Applicant\ApplicantInterface;
use App\Models\Applicant\{Applicant,ApplicantParent,ApplicationProcessing,ApplicantCamps,ApplicantCheckList};
use App\Models\StudentInfo\ParentGuardian;
use Illuminate\Support\Facades\{DB,Log};
use Carbon\Carbon;

class ApplicantRepository implements ApplicantInterface
{
    // public function getAllApplicants()
    // {
    //     return Applicant::with('parents')->get();
    // }

    public function getAllApplicants($search = null, $perPage = 5)
    {
        $query = Applicant::with(['parents', 'interview']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }


    public function getApplicantById($id)
    {
        return Applicant::with(['parents', 'camps', 'checklist', 'processing'])->find($id);
    }

   

    public function createApplicant(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {

                // Create applicant
                $applicant = Applicant::create([
                    'custom_id' => $data['custom_id'] ?? null,
                    'last_name' => $data['last_name'] ?? null,
                    'first_name' => $data['first_name'] ?? null,
                    'high_school' => $data['high_school'] ?? null,
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'usa_cell' => $data['usa_cell'] ?? null,
                    'email' => $data['email'] ?? null,
                    'highschool_application' => $data['highschool_application'] ?? null,
                ]);

                // Applicant Check List
                ApplicantCheckList::create([
                    'applicant_id' => $applicant->id,
                    'fee' => $data['fee'] ?? 0,
                    'cc_last_4' => $data['cc_last_4'] ?? 0,
                    'date_deposited' =>!empty($data['date_deposited']) ? $data['date_deposited'] : null,
                    'reference' => $data['references'] ?? 0,
                    'pictures' => $data['pictures'] ?? 0,
                    'transcript_hebrew' => isset($data['transcript_hebrew']) ? 1 : 0,
                    'transcript_english' => isset($data['transcript_english']) ? 1 : 0,
                ]);

                // Application Processing
                ApplicationProcessing::create([
                    'applicant_id' => $applicant->id,
                    'interview_date' => $data['interview_date'] ?? null,
                    'interview_time' => $data['interview_time'] ?? null,
                    'interview_location' => $data['interview_location'] ?? null,
                    'status' => $data['status'] ?? null,
                    'coming' => $data['coming'] ?? null,
                    'application_comment' => $data['application_comment'] ?? null,
                    'scholarship_comment' => $data['scholarship_comment'] ?? null,
                    'tution_comment' => $data['tution_comment'] ?? null,
                    'letter_sent' => isset($data['letter_sent']) ? 1 : 0,
                ]);

                // Camps (Dynamic Rows)
                if (!empty($data['camps'])) {
                    foreach ($data['camps'] as $camp) {
                        ApplicantCamps::create([
                            'applicant_id' => $applicant->id,
                            'camp' => $camp['camp'] ?? null,
                            'position' => $camp['position'] ?? null,
                        ]);
                    }
                }

                // Create Parent
                $parent = ParentGuardian::create([
                    'father_title' => $data['father_title'] ?? null,
                    'father_name' => $data['father_name'] ?? null,
                    'mother_title' => $data['mother_title'] ?? null,
                    'mother_name' => $data['mother_name'] ?? null,
                    'maiden_name' => $data['maiden_name'] ?? null,
                   
                    'father_mobile' => $data['father_cell'] ?? null,
                    'mother_mobile' => $data['mother_cell'] ?? null,
                    'father_email' => $data['father_email'] ?? null,
                    'mother_email' => $data['mother_email'] ?? null,
                    'father_profession' => $data['father_occupation'] ?? null,
                    'mother_profession' => $data['mother_occupation'] ?? null,
                    'additional_mobile_numbers' => $data['additional_phone_no'] ?? null,
                    'additional_emails' => $data['additional_emails'] ?? null,
                ]);

                // Link Applicant to Parent
                ApplicantParent::create([
                    'applicant_id' => $applicant->id,
                    'parent_id' => $parent->id,
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                    'state' => $data['state'] ?? null,
                    'zip_code' => $data['zip_code'] ?? null,
                    'country' => $data['country'] ?? null,
                    'marital_status' => $data['marital_status'] ?? null,
                    'marital_comment' => $data['marital_comment'] ?? null,
                    'home_phone' => $data['home_phone'] ?? null,
                ]);

                return $applicant->load('parents');
            });

        } catch (\Throwable $e) {
            // Log full error details
            Log::error('Error creating applicant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            // Optionally, rethrow or return a user-friendly error
            throw new \Exception('Failed to create applicant. Please check the logs for details.');
        }
    }


    public function updateApplicant($id, array $data)
    {
        DB::beginTransaction();

        try {
            $applicant = Applicant::with(['checklist', 'processing', 'camps'])->findOrFail($id);

            // Update main applicant fields
            $applicant->update([
                'first_name' => $data['first_name'] ?? $applicant->first_name,
                'last_name' => $data['last_name'] ?? $applicant->last_name,
                'high_school' => $data['high_school'] ?? $applicant->high_school,
                'date_of_birth' => $data['date_of_birth'] ?? $applicant->date_of_birth,
                'usa_cell' => $data['usa_cell'] ?? $applicant->usa_cell,
                'email' => $data['email'] ?? $applicant->email,
                'application_comment' => $data['application_comment'] ?? null,
                'scholarship_comment' => $data['scholarship_comment'] ?? null,
                'tuition_comment' => $data['tuition_comment'] ?? null,
            ]);

            //  Update Checklist
            if (isset($data['checklist'])) {
                $checklistData = $data['checklist'];
                $checklistData['transcript_hebrew'] = isset($data['transcript_hebrew']) ? 1 : 0;
                $checklistData['transcript_english'] = isset($data['transcript_english']) ? 1 : 0;

                if ($applicant->checklist) {
                    $applicant->checklist->update($checklistData);
                } else {
                    $applicant->checklist()->create($checklistData);
                }
            }

            //  Update Processing
            if (isset($data['processing'])) {
                $processingData = $data['processing'];
                $processingData['letter_sent'] = isset($data['letter_sent']) ? 1 : 0;
                $processingData['interview_location'] = $data['interview_location'] ?? null;

                if ($applicant->processing) {
                    $applicant->processing->update($processingData);
                } else {
                    $applicant->processing()->create($processingData);
                }
            }

            //  Update Camps
            if (isset($data['camps']) && is_array($data['camps'])) {
                foreach ($data['camps'] as $campData) {
                    if (!empty($campData['id'])) {
                        $camp = $applicant->camps()->find($campData['id']);
                        if ($camp) {
                            $camp->update([
                                'camp' => $campData['camp'] ?? '',
                                'position' => $campData['position'] ?? '',
                            ]);
                        }
                    } else {
                        $applicant->camps()->create([
                            'camp' => $campData['camp'] ?? '',
                            'position' => $campData['position'] ?? '',
                        ]);
                    }
                }
            }

            //  Update Parents info (if applicable)
            if (isset($data['parents'])) {
                $applicant->parents()->updateOrCreate(
                    ['applicant_id' => $id],
                    $data['parents']
                );
            }

            DB::commit();

            Log::info("Applicant updated successfully in repository", ['applicant_id' => $id]);

            return $applicant;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating applicant: " . $e->getMessage());
            throw $e;
        }
    }


    public function deleteApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        return true;
    }

   

    public function getSlotsBetween($date, $startTime, $endTime)
    {
        return ApplicationProcessing::whereDate('interview_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
                });
            })
            ->get(['id', 'applicant_id', 'interview_date', 'start_time', 'end_time', 'interview_mode', 'interview_location', 'interview_link']);
    }

    // public function getSlotsForWeek($year, $month, $week)
    // {
    //     $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfWeek(Carbon::MONDAY);
    //     $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

    //     $weeks = collect();
    //     $currentStart = $startOfMonth->copy();

    //     while ($currentStart->lte($endOfMonth)) {
    //         $weeks->push([
    //             'start' => $currentStart->copy(),
    //             'end'   => $currentStart->copy()->endOfWeek(Carbon::SUNDAY),
    //         ]);
    //         $currentStart->addWeek();
    //     }

    //     $selectedWeek = $weeks[$week - 1] ?? null;
    //     if (!$selectedWeek) {
    //         return [collect(), null, null];
    //     }

    //     $startDate = $selectedWeek['start'];
    //     $endDate = $selectedWeek['end'];

    //     $daysToShow = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sunday'];

    //     $slots = ApplicationProcessing::whereBetween('interview_date', [$startDate, $endDate])
    //         ->get()
    //         ->filter(fn($slot) => in_array(Carbon::parse($slot->interview_date)->format('l'), $daysToShow));

    //     return [$slots, $startDate, $endDate];
    // }

    public function getSlotsForWeek($startDate, $endDate)
    {
        $daysToShow = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sunday'];

        // Convert to UTC range for database query
        $startUtc = $startDate->copy()->startOfDay()->setTimezone('UTC');
        $endUtc   = $endDate->copy()->endOfDay()->setTimezone('UTC');

        $slots = ApplicationProcessing::whereBetween('interview_date', [$startUtc, $endUtc])->get();

        Log::info('Slots query range (UTC)', [
            'startUtc' => $startUtc->toDateTimeString(),
            'endUtc' => $endUtc->toDateTimeString(),
            'count' => $slots->count(),
        ]);

        return $slots->filter(fn($slot) => in_array(Carbon::parse($slot->interview_date)->format('l'), $daysToShow));
    }


    public function saveInterviewSchedule($data)
    {
        Log::info('Saving interview schedule', ['data' => $data]);

        $formattedTime = date('h:i A', strtotime($data['start_time'])) . ' - ' . date('h:i A', strtotime($data['end_time']));

        return ApplicationProcessing::updateOrCreate(
            ['applicant_id' => $data['applicant_id']],
            [
                'interview_mode'     => $data['interview_mode'],
                'interview_date'     => $data['interview_date'],
                'start_time'         => $data['start_time'],
                'end_time'           => $data['end_time'],
                'interview_time'     => $formattedTime,
                'interview_location' => $data['interview_location'] ?? null,
                'interview_link'     => $data['interview_link'] ?? null,
                'interview_status'   => 1, // 1 = Scheduled
            ]
        );
    }



}
