<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\{Auth,Log};


class CurrentStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   
     

    public function handle(Request $request, Closure $next)
    {
       
        $studentId = session('current_student_id');
        
        // If we have a student ID, validate and set it
        if ($studentId) {
            $student = Student::where('id', $studentId)->where('parent_guardian_id', Auth::id())->first();

            if ($student) {
                // Share globally
                view()->share('currentStudent', $student);

                // Also attach to request for controllers
                $request->attributes->set('currentStudent', $student);
                
            } else {
                // Invalid student ID in session, clear it
                session()->forget('current_student_id');
            }
        } else {
            Log::info('CurrentStudent Middleware - No student ID in session');
        }
        
        return $next($request);
    }
      
}
