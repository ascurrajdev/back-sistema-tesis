<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Collection;

class TransactionOnlinePaymentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_post_callback_a_transaction_via_online_with_debit_target()
    {
        Collection::factory()->create([
            'hook_alias_payment' => 'PCJIZ61978',
            'total_amount' => 10000,
            'link_payment' => 'https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978',
        ]);
        $response = $this->postJson(route('api.online-payments.callback'),[
            "payment" => [
                "hook_alias" => "PCJIZ61978",
                "link_url" => "https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978" ,
                "status" => "confirmed",
                "response_code" => "00", // Tipo de Error
                "response_description" => "Pago exitoso",
                "amount" => 10000,
                "currency" => "GS",
                "installment_number" => 10,
                "description" => "Coca Cola 1 Ltr.",
                "date_time" => "31/10/2019 13:59:39",
                "ticket_number" => 78798374923423,
                "authorization_code" => "134243",
                "commerce_name" => "Supermercado Maravilla",
                "branch_name" => "Sucursal San Vicente",
                "account_type" => "TD",
                "card_last_numbers" => 1234,
                "bin" => "433234",
                "entity_id" => "017",
                "entity_name" => "Banco Itau",
                "brand_id" => "MC",
                "brand_name" => "MasterCard",
                "product_id" => "CLA",
                "product_name" => "Clasica",
                "afinity_id" => null,
                "afinity_name" => null,
                "type" => "QrPayment",
                "payer" => [
                    "name" => "Juan",
                    "lastname" => "Perez",
                    "cellphone" => "098221155",
                    "email" => "test@gmail.com",
                    "notes" => "Notas de ejemplo"
                ],
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('transaction_online_payments',1);
        $response->assertJson([
            'status' => 'success',
            'messages' => [
                [
                    'level' => 'success',
                    'key' => 'Confirmed',
                    'description' => 'Pago recibido con exito',
                ]
            ]
        ]);
    }
    /**
     * @test
     */
    public function can_post_callback_a_transaction_via_online_with_credit_target()
    {
        Collection::factory()->create([
            'hook_alias_payment' => 'PCJIZ61978',
            'total_amount' => 10000,
            'link_payment' => 'https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978',
        ]);
        $response = $this->postJson(route('api.online-payments.callback'),[
            "payment"=> [
                "hook_alias"=> "PCJIZ61978",
                "link_url"=> "https =>//comercios.bancard.com.py/tpago/payment_links/PCJIZ61978" ,
                "status"=> "confirmed",
                "response_code"=> "00", // Tipo de Error
                "response_description"=> "Pago exitoso",
                "amount"=> 10000,
                "currency"=> "GS",
                "installment_number"=> 10,
                "description"=> "Coca Cola 1 Ltr.",
                "date_time"=> "31/10/2019 13:59:39",
                "ticket_number"=> 78798374923423,
                "authorization_code"=> "134243",
                "commerce_name"=> "Supermercado Maravilla",
                "branch_name"=> "Sucursal San Vicente",
                "account_type"=> "TC",
                "card_last_numbers"=> 1234,
                "bin"=> "433234",
                "entity_id"=> "017",
                "entity_name"=> "Banco Itau",
                "brand_id"=> "VS",
                "brand_name"=> "Visa",
                "product_id"=> "CLA",
                "product_name"=> "Clasica",
                "afinity_id"=> "45",
                "afinity_name"=> "SUPERMERCADO STOCK",
                "type"=> "Authorization",
                "payer"=> [
                    "name"=> "Juan",
                    "lastname"=> "Perez",
                    "cellphone"=> "098221155",
                    "email"=> "test@gmail.com",
                    "notes"=> "Notas de ejemplo"
                ]
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('transaction_online_payments',1);
        $response->assertJson([
            'status' => 'success',
            'messages' => [
                [
                    'level' => 'success',
                    'key' => 'Confirmed',
                    'description' => 'Pago recibido con exito',
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function can_post_callback_a_transaction_via_online_with_debit_account_bank()
    {
        Collection::factory()->create([
            'hook_alias_payment' => 'PCJIZ61978',
            'total_amount' => 10000,
            'link_payment' => 'https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978',
        ]);
        $response = $this->postJson(route('api.online-payments.callback'),[
            "payment" => [
                "hook_alias" => "PCJIZ61978",
                "link_url" => "https =>//comercios.bancard.com.py/tpago/payment_links/PCJIZ61978" ,
                "status" => "confirmed",
                "response_code" => "00", // Tipo de Error
                "response_description" => "Pago exitoso",
                "amount" => 10000,
                "currency" => "GS",
                "installment_number" => 10,
                "description" => "Coca Cola 1 Ltr.",
                "date_time" => "31/10/2019 13:59:39",
                "ticket_number" => 78798374923423,
                "authorization_code" => "134243",
                "commerce_name" => "Supermercado Maravilla",
                "branch_name" => "Sucursal San Vicente",
                "account_type" => "DC",
                "card_last_numbers" => 1234,
                "bin" => "433234",
                "entity_id" => "017",
                "entity_name" => "Banco Itau",
                "brand_id" => null,
                "brand_name" => null,
                "product_id" => null,
                "product_name" => null,
                "afinity_id" => null,
                "afinity_name" => null,
                "type" => "QrPayment",
                "payer" => [
                    "name" => "Juan",
                    "lastname" => "Perez",
                    "cellphone" => "098221155",
                    "email" => "test@gmail.com",
                    "notes" => "Notas de ejemplo"
                ],
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('transaction_online_payments',1);
        $response->assertJson([
            'status' => 'success',
            'messages' => [
                [
                    'level' => 'success',
                    'key' => 'Confirmed',
                    'description' => 'Pago recibido con exito',
                ]
            ]
        ]);
    }
    /**
     * @test
     */
    public function can_post_callback_a_transaction_via_online_with_payment_reject()
    {
        Collection::factory()->create([
            'hook_alias_payment' => 'PCJIZ61978',
            'total_amount' => 10000,
            'link_payment' => 'https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978',
        ]);
        $response = $this->postJson(route('api.online-payments.callback'),[
            "payment" => [
                "hook_alias" => "PCJIZ61978",
                "link_url" => "https://comercios.bancard.com.py/tpago/payment_links/PCJIZ61978" ,
                "status" => "failed",
                "response_code" => "51", // Tipo de Error
                "response_description" => "Insuficiencia de fondos",
                "amount" => 10000,
                "currency" => "GS",
                "installment_number" => 10,
                "description" => "Coca Cola 1 Ltr.",
                "date_time" => "31/10/2019 13:59:39",
                "ticket_number" => 78798374923423,
                "authorization_code" => "",
                "commerce_name" => "Supermercado Maravilla",
                "branch_name" => "Sucursal San Vicente",
                "account_type" => "TC",
                "card_last_numbers" => 1234,
                "bin" => "433234",
                "entity_id" => "017",
                "entity_name" => "Banco Itau",
                "brand_id" => "VS",
                "brand_name" => "Visa",
                "product_id" => "CLA",
                "product_name" => "Clasica",
                "afinity_id" => "45",
                "afinity_name" => "SUPERMERCADO STOCK",
                "type" => "Authorization",
                "payer" => [
                    "name" => "Juan",
                    "lastname" => "Perez",
                    "cellphone" => "098221155",
                    "email" => "test@gmail.com",
                    "notes" => "Notas de ejemplo"
                ]
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('transaction_online_payments',1);
        $response->assertJson([
            'status' => 'error',
            'messages' => [
                [
                    'level' => 'error',
                    'key' => 'ConfirmedError',
                    'description' => 'No se pudo procesar la confirmacion'
                ]
            ]
        ]);
    }
}
