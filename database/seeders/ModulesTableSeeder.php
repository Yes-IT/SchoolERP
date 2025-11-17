<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'Student Panel',   'slug' => 'student',   'status' => 1],
            ['name' => 'Teacher Panel',   'slug' => 'teacher',   'status' => 1],
            ['name' => 'Parent Panel',    'slug' => 'parent',    'status' => 1],
            ['name' => 'Super Admin Panel',     'slug' => 'class',     'status' => 1],
        ];

        foreach ($modules as $module) {
            DB::table('modules')->updateOrInsert(
                ['slug' => $module['slug']],
                [
                    'name'       => $module['name'],
                    'status'     => $module['status'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null,
                ]
            );
        }
    }
}
