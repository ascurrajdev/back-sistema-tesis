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
        Schema::create('collection_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_due_id');
            $table->string('concept');
            $table->unsignedBigInteger('currency_id');
            $table->double('amount',12,3);
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('invoice_due_id')->references('id')->on('invoice_dues');
            $table->unsignedBigInteger('collection_id');
            $table->foreign('collection_id')->references('id')->on('collections');
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
        Schema::dropIfExists('collection_details');
    }
};
