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
        Schema::create('uploaded_letters', function (Blueprint $table) {
            $table->id('uploaded_id');
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('request_id')->on('letter_requests')->onDelete('cascade');
            // link file taro disini
            $table->string('link_pdf');
            // validasi user yang mengupload surat
            $table->unsignedBigInteger('validated_by');
            $table->foreign('validated_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_letters');
    }
};
