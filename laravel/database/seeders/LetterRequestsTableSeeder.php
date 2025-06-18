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
                'validated_by'  => null,
                'letter_number' => '001/FAV/IZ-TM/06/2025',
                'category'      => 'Izin_Tidak_Masuk',
                'reason'        => 'Tidak masuk kerja karena urusan keluarga',
                'letter_date'   => now()->addDays(3),
                'status'        => 'pending',
                'is_validated'  => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 4,
                'validated_by'  => null,
                'letter_number' => '002/FAV/IZ-TM/06/2025',
                'category'      => 'Izin_Tidak_Masuk',
                'reason'        => 'Tidak masuk kerja karena urusan mancing',
                'letter_date'   => now()->addDays(10),
                'status'        => 'pending',
                'is_validated'  => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 8,
                'validated_by'  => 2,
                'letter_number' => '001/FAV/CT-TH/07/2025',
                'category'      => 'Cuti_Tahunan',
                'reason'        => 'Cuti tahunan',
                'letter_date'   => now()->addWeek(),
                'status'        => 'approved',
                'is_validated'  => true,
                'created_at'    => now()->subDays(1),
                'updated_at'    => now()->subDays(1),
            ],
            [
                'request_by'    => 12,
                'validated_by'  => 1,
                'letter_number' => '001/FAV/IZ-SK/05/2025',
                'category'      => 'Izin_Sakit',
                'reason'        => 'Tidak masuk kerja karena sakit hati',
                'letter_date'   => now()->addDays(5),
                'status'        => 'cancelled',
                'is_validated'  => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 11,
                'validated_by'  => null,
                'letter_number' => '004/FAV/UND/09/2025',
                'category'      => 'Surat_Undangan',
                'reason'        => 'Undangan bertemu dengan alien',
                'letter_date'   => now()->addDays(10),
                'status'        => 'rejected',
                'is_validated'  => true,
                'created_at'    => now()->subDays(1),
                'updated_at'    => now()->subDays(1),
            ]
        ]);
    }
}
