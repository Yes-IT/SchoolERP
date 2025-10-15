<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranscriptSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'student_id' => 2,
                'destination' => 'University ' . $i,
                'payment_requirement' => ($i % 2 === 0) ? 'yes' : 'no',
                'payment_status' => rand(0, 2), // 0=Pending, 1=Paid, 2=Failed
                'payment_receipt_link' => ($i % 2 === 0) ? "http://example.com/receipt_$i.pdf" : null,
                'status' => rand(0, 2), // 0=Pending, 1=Approved, 2=Rejected
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('transcripts')->insert($data);
    }
}
