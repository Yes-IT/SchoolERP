<?php

namespace App\Interfaces\Applicant;

interface ApplicantInterface
{
    public function getAllApplicants();
    public function getApplicantById($id);
    public function createApplicant(array $data);
    public function updateApplicant($id, array $data);
    public function deleteApplicant($id);
}
