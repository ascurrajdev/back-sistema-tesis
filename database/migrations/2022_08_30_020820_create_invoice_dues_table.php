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
        Schema::create('invoice_dues', function (Blueprint $table) {
            $table->id();
            $table->integer('number_due')->default(1);
            $table->double('amount',12,3);
            $table->boolean('paid')->default(false);
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');
            $table->unsignedBigInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->timestamp('expiration_date');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->on('invoices')->references('id');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->foreign('reservation_id')->on('reservations')->references('id');
            $table->boolean('is_initial_reservation_payment')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('invoice_dues');
    }
};
