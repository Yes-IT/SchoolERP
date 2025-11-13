<?php

namespace App\Interfaces\Staff;

interface TeacherInterface
{
    public function all();

    public function getPaginateAll();

    public function searchTeachers($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function filter($request);

    public function fetchClasses($id);

    
}
