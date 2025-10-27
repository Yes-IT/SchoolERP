<?php

namespace App\Repositories\Report;

use App\Interfaces\Report\ReportFilterInterface;
use App\Models\Academic\Classes;
use App\Models\StudentInfo\Student;
use App\Models\Academic\Semester;
use App\Models\Academic\YearStatus;
use App\Models\Session;

class ReportFilterRepository implements ReportFilterInterface
{
    public function getClasses()
    {
        return Classes::all();
    }

    public function getStudents()
    {
        return Student::all();
    }

    public function getSemesters()
    {
        return Semester::all();
    }

    public function getYearStatuses()
    {
        return YearStatus::all();
    }

    public function getschoolyears()
    {
        return Session::all();
    }
}