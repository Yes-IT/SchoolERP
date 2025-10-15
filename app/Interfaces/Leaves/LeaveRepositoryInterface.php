<?php

namespace App\Interfaces\Leaves;

use Illuminate\Http\Request;

interface LeaveRepositoryInterface
{
    public function getStudentLeaves(Request $request);
}
