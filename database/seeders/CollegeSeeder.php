<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colleges')->insert([
            [
                'name' => 'National Science College',
                'is_funded' => true,
                'amount' => 500000.00,
                'date' => Carbon::now()->subDays(10),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'City Arts College',
                'is_funded' => false,
                'amount' => null,
                'date' => Carbon::now()->subDays(8),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tech University',
                'is_funded' => true,
                'amount' => 1200000.00,
                'date' => Carbon::now()->subDays(7),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Global Business School',
                'is_funded' => true,
                'amount' => 800000.00,
                'date' => Carbon::now()->subDays(6),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Riverdale College',
                'is_funded' => false,
                'amount' => null,
                'date' => Carbon::now()->subDays(5),
                'status' => 'rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sunrise Polytechnic',
                'is_funded' => true,
                'amount' => 350000.00,
                'date' => Carbon::now()->subDays(4),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Evergreen Arts Institute',
                'is_funded' => false,
                'amount' => null,
                'date' => Carbon::now()->subDays(3),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Skyline Technical College',
                'is_funded' => true,
                'amount' => 950000.00,
                'date' => Carbon::now()->subDays(2),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Valley Medical University',
                'is_funded' => true,
                'amount' => 1500000.00,
                'date' => Carbon::now()->subDay(),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Greenfield College',
                'is_funded' => false,
                'amount' => null,
                'date' => Carbon::now(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
