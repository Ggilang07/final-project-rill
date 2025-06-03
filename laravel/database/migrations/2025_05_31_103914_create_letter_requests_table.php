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
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled']);
            $table->enum('category', ['izin', 'sakit', 'cuti', 'lainnya']);
            // alasan pengajuan surat
            $table->string('reason');
            // penomoran surat
            $table->string('letter_number', 255);
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
