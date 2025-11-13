<?php

namespace App\Repositories\Applicant;

use App\Interfaces\Applicant\ApplicantInterface;
use App\Models\Applicant\{Applicant,ApplicantParent,ApplicationProcessing,ApplicantHistory,ApplicantCamps,ApplicantCheckList};
use App\Models\StudentInfo\ParentGuardian;
use Illuminate\Support\Facades\{DB,Log};
use Carbon\Carbon;

class ApplicantRepository implements ApplicantInterface
{

   
    public function getAllApplicants($search = null, $perPage = 5, $sessionId = null, $yearStatusId = null, $applicantName = null)
    {
        $query = Applicant::with(['parents', 'processing'])
                    ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
                
            });
        }

        if ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        if ($yearStatusId) {
            $query->where('year_status_id', $yearStatusId);
        }

        if ($applicantName) {
            $query->where(function ($q) use ($applicantName) {
                $q->where('first_name', 'like', "%{$applicantName}%")
                ->orWhere('last_name', 'like', "%{$applicantName}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$applicantName}%"]);
            });
        }

        return $query->paginate($perPage);
    }

    public function getApplicantNames()
    {
        return Applicant::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function ($applicant) {
                $applicant->full_name = $applicant->first_name . ' ' . $applicant->last_name;
                return $applicant;
            });
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

    public function getApplicantById($id)
    {
        return Applicant::with(['parents','history' ,'highSchool' ,'confirmation', 'processing','transaction'])->find($id);
    }

    
    public function updateApplicant($id, array $data)
    {
        DB::beginTransaction();

        try {
            // Log::info('Repository update started', ['applicant_id' => $id, 'all_data' => $data]);
            
            $applicant = Applicant::with(['processing','transaction','confirmation','parents'])->findOrFail($id);

            $applicantData = [
                'first_name' => $data['first_name'] ?? $applicant->first_name,
                'last_name' => $data['last_name'] ?? $applicant->last_name,
                'date_of_birth' => $data['date_of_birth'] ?? $applicant->date_of_birth,
                'usa_cell' => $data['usa_cell'] ?? $applicant->usa_cell,
                'email' => $data['email'] ?? $applicant->email,
                'highschool_application' => $data['highschool_application'] ?? $applicant->highschool_application,
                'high_school' => $data['high_school'] ?? $applicant->high_school,
            ];
            
            if (isset($data['high_school_id']) && $data['high_school_id'] !== null) {
                $applicantData['high_school_id'] = $data['high_school_id'];
            } else {
                $applicantData['high_school_id'] = null;
            }
            
            // Log::info('Applicant data before update:', $applicantData);
            
            $result = $applicant->update($applicantData);
            // Log::info('Update result:', ['result' => $result]);
            
            $applicant->refresh();
        
           if (isset($data['processing'])) {
                // Log::info('Updating processing with:', $data['processing']);
                $processingData = $data['processing'];
                
                $processingData = array_filter($processingData, function($value) {
                    return $value !== '' && $value !== null;
                });
                
                if (!empty($processingData)) {
                    $processingData['letter_sent'] = isset($processingData['letter_sent']) ? 1 : 0;
                    $processingData['interview_status'] = isset($processingData['interview_status']) ? (int)$processingData['interview_status'] : 0;

                    $existingProcessing = ApplicationProcessing::where('applicant_id', $applicant->id)->first();
                    if ($existingProcessing) {
                        $existingProcessing->update($processingData);
                    } else {
                        $processingData['applicant_id'] = $applicant->id;
                        $processingData['interview_status'] = $processingData['interview_status'] ?? 0;
                        $processingData['letter_sent'] = $processingData['letter_sent'] ?? 0;
                        
                        ApplicationProcessing::create($processingData);
                    }
                } else {
                    Log::info('No meaningful processing data to save, skipping update');
                }
            }

            if (isset($data['parents']) && $applicant->parents->isNotEmpty()) {
                // Log::info('Updating parents with:', $data['parents']);
                $parent = $applicant->parents->first();
                $parent->update($data['parents']);
            }

            if (isset($data['transaction']) && $applicant->transaction) {
                // Log::info('Updating transaction with:', $data['transaction']);
                $applicant->transaction->update($data['transaction']);
            }

            if (isset($data['checklist']) && $applicant->confirmation) {
                // Log::info('Updating checklist with:', $data['checklist']);
                $checklistData = $data['checklist'];
                $checklistData['transcript_hebrew'] = isset($checklistData['transcript_hebrew']) ? 1 : 0;
                $checklistData['transcript_english'] = isset($checklistData['transcript_english']) ? 1 : 0;
                $applicant->confirmation->update($checklistData);   
            }

            if (isset($data['school_name']) || isset($data['school_grades'])) {
                $history = ApplicantHistory::where('applicant_id', $id)->first();
                if ($history) {
                    $historyData = [];
                    if (isset($data['school_name'])) $historyData['school_name'] = $data['school_name'];
                    if (isset($data['school_grades'])) $historyData['school_grades'] = $data['school_grades'];
                    $history->update($historyData); 
                } else {
                    Log::warning('No history record found for applicant', ['applicant_id' => $id]);
                }
            }
            DB::commit();
            // Log::info("Applicant updated successfully in repository", ['applicant_id' => $id]);
            return $applicant;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating applicant: " . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function deleteApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        return true;
    }

    public function getSlotsForWeek($startDate, $endDate)
    {
        $daysToShow = [1, 2, 3, 4, 5, 0]; 
        
        return ApplicationProcessing::whereBetween('interview_date', [
            $startDate->startOfDay(), 
            $endDate->endOfDay()
        ])
        ->with('applicant')
        ->get()->filter(function($slot) use ($daysToShow) {
            $slotDay = Carbon::parse($slot->interview_date)->dayOfWeek;
            return in_array($slotDay, $daysToShow);
        });
    }

    public function getSlotsBetween($date, $startTime = null, $endTime = null, $interviewMode = null)
    {
        $query = ApplicationProcessing::whereDate('interview_date', $date);

        // Only apply time range filter if both start_time and end_time are provided
        if ($startTime && $endTime) {
            $query->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
                });
            });
        }
        else {
            $query->orderBy('start_time', 'asc');
        }

        return $query->get(['id', 'applicant_id', 'interview_date', 'start_time', 'end_time', 'interview_mode', 'interview_location', 'interview_link']);
    }

    public function checkOverlappingSlots($date, $startTime, $endTime, $excludeApplicantId = null)
    {
        $query = ApplicationProcessing::whereDate('interview_date', $date)
            ->where(function($q) use ($startTime, $endTime) {
                $q->where(function($inner) use ($startTime, $endTime) {
                    $inner->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            });

        if ($excludeApplicantId) {
            $query->where('applicant_id', '!=', $excludeApplicantId);
        }
        return $query->exists();
    }

    public function saveInterviewSchedule($data)
    {
        $overlapping = $this->checkOverlappingSlots(
            $data['interview_date'],
            $data['start_time'],
            $data['end_time'],
            $data['applicant_id'] 
        );

        if ($overlapping) {
            throw new \Exception('This time slot conflicts with an existing interview for another applicant. Please choose a different time.');
        }

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


    public function updateInterviewSchedule($data)
    {
        // Log::info('Updating interview schedule', ['data' => $data]);
        $overlapping = $this->checkOverlappingSlots(
            $data['interview_date'],
            $data['start_time'],
            $data['end_time'],
            $data['applicant_id'] 
        );

        if ($overlapping) {
            throw new \Exception('This time slot conflicts with an existing interview for another applicant. Please choose a different time.');
        }

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
                'interview_status'   => 2, // 2 = Rescheduled
            ]
        );
    }


}
