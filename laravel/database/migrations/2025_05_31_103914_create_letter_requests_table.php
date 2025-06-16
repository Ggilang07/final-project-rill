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
            $table->unsignedBigInteger('validated_by')->nullable();;
            $table->foreign('validated_by')->references('user_id')->on('users')->onDelete('cascade');
            // penomoran surat
            $table->string('letter_number', 255);
            $table->enum('category', [
                'IZIN_TIDAK_MASUK',
                'IZIN_TERLAMBAT',
                'IZIN_PULANG_AWAL',
                'IZIN_SAKIT',

                'CUTI_TAHUNAN',
                'CUTI_MELAHIRKAN',
                'CUTI_MENIKAH',
                'CUTI_KEMATIAN',
                'CUTI_IBADAH',
                'CUTI_BESAR',

                'DINAS_LUAR',
                'WORK_FROM_HOME',

                'SURAT_KETERANGAN_KERJA',
                'SURAT_KETERANGAN_PENGHASILAN',
                'SURAT_KETERANGAN_AKTIF',

                'SURAT_TUGAS',
                'SURAT_REKOMENDASI',
                'SURAT_UNDANGAN',
                'SURAT_PENGUNDURAN_DIRI'
            ]);
            // alasan pengajuan surat
            $table->string('reason');
            $table->date('letter_date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled']);
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
