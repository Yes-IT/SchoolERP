<?php

namespace App\Interfaces\Report;

interface ReportFilterInterface
{
    public function getClasses();
    public function getStudents();
    public function getSemesters();
    public function getYearStatuses();
    public function getschoolyears();

}