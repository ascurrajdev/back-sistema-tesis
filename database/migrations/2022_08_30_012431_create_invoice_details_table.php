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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('tax_id');
            $table->integer('tax_rate');
            $table->double('amount',12,3);
            $table->double('amount_untaxed',12,3);
            $table->double('amount_discount',12,3);
            $table->double('quantity',8,2);
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('invoice_details');
    }
};
