<?php

namespace App\Interfaces\Staff;

interface StudentInterface
{
    public function all();
    public function filter($request);
}