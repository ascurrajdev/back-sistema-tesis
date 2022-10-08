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
            $table->string('hook_alias');
            $table->string('link_url');
            $table->string("status");
            $table->string("response_code");
            $table->string("response_description");
            $table->integer("amount");
            $table->string("currency");
            $table->integer("installment_number");
            $table->string("description");
            $table->timestamp("date_time");
            $table->bigInteger("ticket_number");
            $table->string("authorization_code");
            $table->string("commerce_name");
            $table->string("account_type");
            $table->integer("card_last_numbers")->nullable();
            $table->string("bin")->nullable();
            $table->string("entity_id");
            $table->string("entity_name");
            $table->string("brand_id")->nullable();
            $table->string("brand_name")->nullable();
            $table->string("product_id")->nullable();
            $table->string("product_name")->nullable();
            $table->string("type")->nullable();
            $table->string("payer_name")->nullable();
            $table->string("payer_lastname")->nullable();
            $table->string("payer_cellphone")->nullable();
            $table->string("payer_email")->nullable();
            $table->string("payer_notes")->nullable();
            $table->timestamp("revert_at")->nullable();
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
        Schema::dropIfExists('transaction_online_payments');
    }
};
