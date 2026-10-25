<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id')->nullable()->index();
            $table->string('payment_intent')->nullable();
            $table->string('refund_id')->nullable();
            $table->decimal('refunded_amount', 10, 2)->default(0);
        });

        Schema::table('reservationTable', function (Blueprint $table) {
            $table->decimal('refund_amount', 10, 2)->default(0);
            $table->string('refund_status')->nullable(); // refunded | non_refundable | none
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['reservation_id', 'payment_intent', 'refund_id', 'refunded_amount']);
        });
        Schema::table('reservationTable', function (Blueprint $table) {
            $table->dropColumn(['refund_amount', 'refund_status']);
        });
    }
};