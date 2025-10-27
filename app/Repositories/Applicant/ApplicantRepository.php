<?php

namespace App\Repositories\Applicant;

use App\Interfaces\Applicant\ApplicantInterface;
use App\Models\Applicant\{Applicant,ApplicantParent,ApplicationProcessing,ApplicantCamps,ApplicantCheckList};
use App\Models\StudentInfo\ParentGuardian;
use Illuminate\Support\Facades\{DB,Log};

class ApplicantRepository implements ApplicantInterface
{
    public function getAllApplicants()
    {
        return Applicant::with('parents')->get();
    }

    public function getApplicantById($id)
    {
        return Applicant::with('parents')->findOrFail($id);
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
        $applicant = Applicant::findOrFail($id);
        $applicant->update($data);
        return $applicant;
    }

    public function deleteApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        return true;
    }
}
