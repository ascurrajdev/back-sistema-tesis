<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->double('total_amount',12,3);
            $table->unsignedBigInteger('currency_id');
            $table->double('total_discount',12,3);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('agency_id');
            $table->integer('quantity_people')->default(0);
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->boolean('active')->default(false);
            $table->enum("status", ["pending","reserved","cancelled","completed"])->default("pending");
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
        Schema::dropIfExists('reservations');
    }
};
