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
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('product_pricing_profile_id');
            $table->double('amount',12,3);
            $table->double('discount',12,3);
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_pricing_profile_id')->references('id')->on('product_pricing_profiles');
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
        Schema::dropIfExists('reservation_details');
    }
};
