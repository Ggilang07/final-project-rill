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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('name', 255);
            $table->date('date_of_birth');
            $table->string('address', 255);
            $table->bigInteger('no_kk');
            $table->bigInteger('nik');
            $table->enum('role', ['admin', 'karyawan']);
            $table->string('token_reset')->nullable();
            $table->dateTime('reset_expired_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};