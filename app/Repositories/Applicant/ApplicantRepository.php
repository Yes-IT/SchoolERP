<?php

namespace App\Repositories\Applicant;

use App\Interfaces\Applicant\ApplicantInterface;
use App\Models\Applicant\{Applicant,ApplicantParent};
use App\Models\StudentInfo\ParentGuardian;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {

           
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

          
            $parent = ParentGuardian::create([
                'father_title' => $data['father_title'] ?? null,
                'father_name' => $data['father_name'] ?? null,
                'mother_title' => $data['mother_title'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
                'maiden_name' => $data['maiden_name'] ?? null,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'zip_code' => $data['zip_code'] ?? null,
                'country' => $data['country'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,
                'marital_comment' => $data['marital_comment'] ?? null,
                'home_phone' => $data['home_phone'] ?? null,
                'father_cell' => $data['father_cell'] ?? null,
                'mother_cell' => $data['mother_cell'] ?? null,
                'father_email' => $data['father_email'] ?? null,
                'mother_email' => $data['mother_email'] ?? null,
                'father_occupation' => $data['father_occupation'] ?? null,
                'mother_occupation' => $data['mother_occupation'] ?? null,
                'additional_phone_no' => $data['additional_phone_no'] ?? null,
                'additional_emails' => $data['additional_emails'] ?? null,
            ]);

           
            ApplicantParent::create([
                'applicant_id' => $applicant->id,
                'parent_id' => $parent->id,
            ]);

            return $applicant->load('parents');
        });
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
