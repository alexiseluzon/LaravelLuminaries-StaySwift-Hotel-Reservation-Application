<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skip if the table was created by hand earlier
        if (Schema::hasTable('users_verify')) {
            return;
        }

        Schema::create('users_verify', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('token', 64)->unique();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('userTable')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_verify');
    }
};