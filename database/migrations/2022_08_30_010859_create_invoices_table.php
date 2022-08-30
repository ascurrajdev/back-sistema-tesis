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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->double('total_amount',12,3)->default(0);
            $table->double('total_discount',12,3)->default(0);
            $table->double('total_amount_untaxed',12,3)->default(0);
            $table->double('total_paid',12,3)->default(0);
            $table->boolean('paid_cancelled')->default(true);
            $table->enum('operation_type',['contado','credito'])->default('contado');
            $table->date('expiration_date')->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('invoices');
    }
};
