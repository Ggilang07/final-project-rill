<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'request_by' => 4,
                'template_id' => 1,
                'status' => 'pending',
                'request_at' => now(),
                'validated_by' => 1,
                'letter_number' => '001/HRD/2025',
                'file_output' => 'izin_tidak_masuk_kerja_user4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'request_by' => 4,
                'template_id' => 2,
                'status' => 'approved',
                'request_at' => now()->subDays(1),
                'validated_by' => 2,
                'letter_number' => '002/HRD/2025',
                'file_output' => 'cuti_tahunan_user4.pdf',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ]
            ]);
        
    }
}