<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LetterRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('letter_requests')->insert([
            [
                'request_by'    => 4,
                'status'        => 'pending',
                'category'      => 'izin',
                'reason'        => 'Tidak masuk kerja karena urusan keluarga',
                'letter_number' => '001/HRD/2025',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 4,
                'status'        => 'approved',
                'category'      => 'cuti',
                'reason'        => 'Cuti tahunan',
                'letter_number' => '002/HRD/2025',
                'created_at'    => now()->subDays(1),
                'updated_at'    => now()->subDays(1),
            ]
        ]);
    }
}