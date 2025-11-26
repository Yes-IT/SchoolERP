<?php
namespace App\Interfaces\Staff;


interface AssignmentInterface
{
    public function createAssignment(array $data, array $files = []);
    public function getByTeacher($teacherId);
    public function getByStatus($teacherId, $status);
    public function find($id);
    public function update($id, array $data);
    public function uploadMedia($assignmentId, $file);
    public function getMedia($assignmentId);
    public function getSubmissionsForEvaluation($assignmentId);
    public function saveEvaluation($assignmentId, $request);
}
