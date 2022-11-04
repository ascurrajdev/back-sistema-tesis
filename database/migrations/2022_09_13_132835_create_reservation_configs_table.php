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
        Schema::create('reservation_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_partial_payment')->comment('Acepta pagos parciales')->default(false);
            $table->double('initial_payment_percent',8,2)->comment('El porcentaje del pago inicial')->nullable();
            $table->integer('max_quantity_quotes')->comment('Cantidad maxima de pagos')->default(1);
            $table->integer('max_days_expiration_initial_payment')->comment('La cantidad maxima de dias para hacer el pago inicial')->default(1);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('budget_configs');
    }
};
