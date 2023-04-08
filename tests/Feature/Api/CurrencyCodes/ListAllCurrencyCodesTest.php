<?php

namespace Tests\Feature\Api\CurrencyCodes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListAllCurrencyCodesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_currency_codes_with_name_country()
    {
        $response = $this->getJson(route('api.currency-codes.index'));
        $response->assertStatus(200);
    }
}
