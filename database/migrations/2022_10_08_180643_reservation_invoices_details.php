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
        Schema::create('reservation_invoices_details', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('reservation_id')->on('reservations')->references('id');
            $table->foreign('invoice_id')->on('invoices')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_invoices_details');
    }
};
