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
        Schema::create('collection_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('currency_id');
            $table->double('amount',12,3)->default(0);
            $table->integer('nro_transaction');
            $table->unsignedBigInteger('transaction_online_payment_id')->nullable();
            $table->foreign('transaction_online_payment_id')->on('transaction_online_payments')->references('id');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('collection_payment_details');
    }
};
