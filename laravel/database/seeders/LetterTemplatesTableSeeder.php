<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LetterTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('letter_templates')->insert([
            [
                'title' => 'Surat Izin Tidak Masuk Kerja',
                'category' => 'izin',
                'description' => 'Digunakan oleh karyawan yang berhalangan hadir karena sakit atau keperluan pribadi.',
                'content' => 'Kepada Yth. [Nama Atasan]
    Di Tempat
    
    Dengan hormat,
    
    Saya yang bertanda tangan di bawah ini:
    Nama    : [Nama Karyawan]
    Jabatan : [Jabatan]
    
    Dengan ini mengajukan permohonan izin tidak masuk kerja pada tanggal [Tanggal Izin] dikarenakan [Alasan].
    
    Demikian surat ini saya sampaikan, atas perhatian dan pengertiannya saya ucapkan terima kasih.',
                'file_pdf' => 'izin_tidak_masuk_kerja.pdf',
                'file_docx' => 'izin_tidak_masuk_kerja.docx',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Surat Cuti Tahunan',
                'category' => 'izin',
                'description' => 'Template surat pengajuan cuti tahunan oleh karyawan.',
                'content' => 'Kepada Yth. [Nama Atasan]
    Di Tempat
    
    Dengan hormat,
    
    Saya yang bertanda tangan di bawah ini:
    Nama    : [Nama Karyawan]
    Jabatan : [Jabatan]
    
    Dengan ini mengajukan cuti tahunan selama [Jumlah Hari] hari kerja, terhitung mulai tanggal [Tanggal Mulai] sampai [Tanggal Selesai].
    
    Demikian permohonan ini saya buat untuk dapat dipertimbangkan dan disetujui. Atas perhatian Bapak/Ibu saya ucapkan terima kasih.',
                'file_pdf' => 'cuti_tahunan.pdf',
                'file_docx' => 'cuti_tahunan.docx',
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}