<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Report\MarksheetRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Interfaces\Report\ReportFilterInterface;
use PDF;

class ReportManagementController extends Controller
{
    private $repo;
    private $classRepo;
    private $classSetupRepo;
    private $studentRepo;
    private $filterRepo;

    public function __construct(
        MarksheetRepository $repo,
        ClassesRepository $classRepo,
        ClassSetupRepository $classSetupRepo,
        StudentRepository $studentRepo,
        ReportFilterInterface $filterRepo
    ) {
        $this->repo = $repo;
        $this->classRepo = $classRepo;
        $this->classSetupRepo = $classSetupRepo;
        $this->studentRepo = $studentRepo;
        $this->filterRepo = $filterRepo;
    }

    private function getFilterOption(array $needed = [])
    {
        $filters = [];

        if (in_array('school_years', $needed)) {
            $filters['school_years'] = $this->filterRepo->getSchoolYears();
        }

        if (in_array('year_statuses', $needed)) {
            $filters['year_statuses'] = $this->filterRepo->getYearStatuses();
        }

        if (in_array('classes', $needed)) {
            $filters['classes'] = $this->filterRepo->getClasses();
        }

        if (in_array('semesters', $needed)) {
            $filters['semesters'] = $this->filterRepo->getSemesters();
        }

        if (in_array('students', $needed)) {
            $filters['students'] = $this->filterRepo->getStudents();
        }

        return $filters;
    }

    public function index()
    {
        $data = $this->getFilterOption();
        return view('backend.report.index', compact('data'));
    }

    public function generalStudentReport()
    {
        $data = $this->getFilterOption(['school_years', 'year_statuses','classes', 'semesters']);
        return view('backend.report.general-student-report', compact('data'));
    }

    public function teacherReport()
    {
        $data = $this->getFilterOption(['school_years', 'year_statuses']);
        return view('backend.report.teacher-report', compact('data'));
    }

    public function alumniReport()
    {
        $data = $this->getFilterOption();
        return view('backend.report.alumni-report', compact('data'));
    }

    public function attendanceReport()
    {
        $data = $this->getFilterOption(['school_years', 'year_statuses','classes', 'semesters', 'students']);
        return view('backend.report.attendance-report', compact('data'));
    }

    public function schoolGradeReport()
    {
        $data = $this->getFilterOption();
        return view('backend.report.school-grade-report', compact('data'));
    }

    public function classReport()
    {
        $data = $this->getFilterOption();
        return view('backend.report.class-report', compact('data'));
    }

    public function applicantReport()
    {
        $data = $this->getFilterOption();
        return view('backend.report.applicant-report', compact('data'));
    }

    public function tuitionReport()
    {
        $data = $this->getFilterOption();
        return view('backend.report.tuition-report', compact('data'));
    }
}