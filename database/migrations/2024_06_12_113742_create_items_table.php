<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('item_quantity');
            $table->string('category');
            $table->string('unit_of_measure');
            $table->string('room_number');
            $table->string('school_level');
            $table->string('adviser');
            $table->integer('borrowed_items')->default(0);
            $table->integer('overdue_items')->default(0);
            $table->integer('damaged_items')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
