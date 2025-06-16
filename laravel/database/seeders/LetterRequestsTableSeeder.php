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
                'category'      => 'IZIN_TIDAK_MASUK',
                'reason'        => 'Tidak masuk kerja karena urusan keluarga',
                'status'        => 'pending',
                'letter_date'   => now()->addDays(3), // 3 hari ke depan
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 8,
                'validated_by'  => 2,
                'letter_number' => '001/FAV/CT-TH/07/2025',
                'category'      => 'CUTI_TAHUNAN',
                'reason'        => 'Cuti tahunan',
                'status'        => 'approved',
                'letter_date'   => now()->addWeek(), // 1 minggu ke depan
                'created_at'    => now()->subDays(1),
                'updated_at'    => now()->subDays(1),
            ],
            [
                'request_by'    => 12,
                'validated_by'  => 1,
                'letter_number' => '001/FAV/IZ-SK/05/2025',
                'category'      => 'IZIN_SAKIT',
                'reason'        => 'Tidak masuk kerja karena sakit hati',
                'status'        => 'cancelled',
                'letter_date'   => now()->addDays(5), // 5 hari ke depan
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'request_by'    => 11,
                'validated_by'  => null,
                'letter_number' => '004/FAV/UND/09/2025',
                'category'      => 'SURAT_UNDANGAN',
                'reason'        => 'Undangan bertemu dengan alien',
                'status'        => 'rejected',
                'letter_date'   => now()->addDays(10), // 10 hari ke depan
                'created_at'    => now()->subDays(1),
                'updated_at'    => now()->subDays(1),
            ]
        ]);
    }
}
