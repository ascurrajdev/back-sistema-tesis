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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount',12,3);
            $table->double('amount_untaxed',12,3);
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->boolean('active_for_reservation')->default(false);
            $table->boolean('is_lodging')->default(false);
            $table->integer('capacity_for_day_max')->nullable()->default(0);
            $table->integer('capacity_for_day_min')->nullable()->default(0);
            $table->boolean('stockable')->default(false);
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
        Schema::dropIfExists('products');
    }
};
