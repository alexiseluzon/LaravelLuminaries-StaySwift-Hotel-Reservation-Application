<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roomTable', function (Blueprint $table) {
            $table->string('status')->nullable(); // Adding the new column
        });
    }

    public function down(): void
    {
        Schema::table('roomTable', function (Blueprint $table) {
            $table->dropColumn('status'); // Dropping the column on rollback
        });
    }
};
