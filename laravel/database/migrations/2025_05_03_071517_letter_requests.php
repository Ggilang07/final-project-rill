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
            $table->unsignedBigInteger('request_by');
            $table->unsignedBigInteger('template_id');
            $table->enum('status', ['pending', 'approved', 'rejected', 'printed']);
            $table->dateTime('request_at');
            $table->unsignedBigInteger('validated_by');
            $table->string('letter_number', 255);
            $table->string('file_output', 255);
            $table->timestamps();
            $table->foreign('request_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('template_id')->references('template_id')->on('letter_templates')->onDelete('cascade');
            $table->foreign('validated_by')->references('user_id')->on('users')->onDelete('cascade');

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
