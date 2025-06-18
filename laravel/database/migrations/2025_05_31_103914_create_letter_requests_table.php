<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id('request_id');
            // permintaan dari users/karyawan
            $table->unsignedBigInteger('request_by');
            $table->foreign('request_by')->references('user_id')->on('users')->onDelete('cascade');
            // validasi user yang mengupload surat
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->foreign('validated_by')->references('user_id')->on('users')->onDelete('cascade');
            // penomoran surat
            $table->string('letter_number', 255);
            $table->enum('category', [
                'Izin_Tidak_Masuk',
                'Izin_Terlambat',
                'Izin_Pulang_Awal',
                'Izin_Sakit',

                'Cuti_Tahunan',
                'Cuti_Melahirkan',
                'Cuti_Menikah',
                'Cuti_Kematian',
                'Cuti_Ibadah',
                'Cuti_Besar',

                'Dinas_Luar',
                'Work_From_Home',

                'Surat_Keterangan_Kerja',
                'Surat_Keterangan_Penghasilan',
                'Surat_Keterangan_Aktif',

                'Surat_Tugas',
                'Surat_Rekomendasi',
                'Surat_Undangan',
                'Surat_Pengunduran_Diri'
            ]);
            // alasan pengajuan surat
            $table->string('reason');
            // tanggal surat yang diajukan
            $table->date('letter_date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled']);
            $table->boolean('is_validated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_requests');
    }
};
