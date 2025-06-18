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
                'request_id' => 3,
                'link_pdf' => 'https://drive.google.com/drive/home',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
