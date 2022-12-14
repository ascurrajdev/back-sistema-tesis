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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->double('total_amount',12,3)->default(0);
            $table->double('total_amount_paid',12,3)->default(0);
            $table->boolean("is_paid")->default(false);
            $table->string("link_payment")->nullable();
            $table->string("hook_alias_payment")->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('collections');
    }
};
