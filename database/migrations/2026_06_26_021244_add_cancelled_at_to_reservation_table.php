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
        Schema::table('reservationTable', function (Blueprint $table) {
            $table->timestamp('cancelled_at')->nullable()->after('status');
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservationTable', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'status']);
        });
    }
};
