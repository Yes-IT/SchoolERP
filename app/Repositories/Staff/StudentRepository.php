<?php

namespace App\Repositories\Staff;

use App\Interfaces\Staff\StudentInterface;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Log;

class StudentRepository implements StudentInterface
{
    
    // public function all()
    // {
    //     // return Student::with(['classes.yearStatus','classes.subject','parent'])->get();
    //      return Student::with(['classes.yearStatus','classes.subject','parent'])
    //             ->orderBy('id', 'DESC')
    //             ->paginate(request('per_page', 10)); 
    // }

    public function all()
    {
        $teacherId = auth()->user()->staff->id;

        // dd($teacherId);

        return Student::with(['classes.yearStatus', 'classes.subject', 'parent'])
                ->whereHas('classMappings', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })
                ->orderBy('id', 'DESC')
                ->paginate(request('per_page', 10));
    }
    
    public function filter($request)
    {

        $teacherId = auth()->user()->staff->id;

        $query = Student::with(['classes.yearStatus', 'classes.subject', 'parent'])
            ->whereHas('classMappings', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            });

        if ($request->year_status && $request->year_status !== 'all') {
            $query->whereHas('classes.yearStatus', function($q) use ($request) {
                $q->where('id', $request->year_status);
            });
        }

        if ($request->subject && $request->subject !== 'all') {
            $query->whereHas('classes.subject', function($q) use ($request) {
                $q->where('id', $request->subject);
            });
        }

        return $query->orderBy('id', 'DESC')
                ->paginate($request->per_page ?? 10);
    }

}
