<?php

namespace App\Interfaces\Academic;

interface AssignmentInterface
{
    public function all();
    public function store($request);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
    public function getPendingAssignmentRequests();
    public function getAcceptedAssignmentRequests($request);
    public function getRejectedAssignmentRequests();
    public function changeStatus($id, $status);
    public function filterAssignments(array $filters);

}
