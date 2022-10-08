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
        Schema::create('invoice_collection_details', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('collection_id');
            $table->foreign('invoice_id')->on('invoices')->references('id');
            $table->foreign('collection_id')->on('collections')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_collection_details');
    }
};
