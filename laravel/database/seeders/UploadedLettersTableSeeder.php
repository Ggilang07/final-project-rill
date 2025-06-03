<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadedLettersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('uploaded_letters')->insert([
            [
                'request_id' => 1,
                'validated_by' => 1,
                'link_pdf' => 'surat_izin_user4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'request_id' => 2,
                'validated_by' => 2,
                'link_pdf' => 'surat_cuti_user4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
