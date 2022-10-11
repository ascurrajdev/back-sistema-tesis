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
        Schema::create('transaction_online_payments', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->boolean('is_reverse')->default(false);
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->foreign('collection_id')->on('collections')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_online_payments');
    }
};
