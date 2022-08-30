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
        Schema::create('transfer_stocks', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->double('quantity',8,2);
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('user_from_id')->nullable();
            $table->unsignedBigInteger('user_destination_id')->nullable();
            $table->unsignedBigInteger('agency_from_id')->nullable();
            $table->unsignedBigInteger('agency_destination_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_from_id')->references('id')->on('users');
            $table->foreign('user_destination_id')->references('id')->on('users');
            $table->foreign('agency_destination_id')->references('id')->on('agencies');
            $table->foreign('agency_from_id')->references('id')->on('agencies');
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
        Schema::dropIfExists('transfer_stocks');
    }
};
