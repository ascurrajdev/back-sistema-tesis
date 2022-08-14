<?php

namespace Tests\Feature\Api\Auth\Clients;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function check_if_login_success_with_correct_request()
    {
        $client = Client::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            "email" => $client->email,
            "password" => "password"
        ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                "token",
                "client"
            ]
        ]);
    }
    /**
     * @test
     */
    public function check_required_email()
    {
        // $user = User::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            // "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("email");
    }
    /**
     * @test
     */
    public function check_required_password()
    {
        $client = Client::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            "email" => $client->email,
            // "password" => "password"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("password");
    }
    /**
     * @test
     */
    public function check_correct_format_email()
    {
        // $user = User::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            "email" => "hola",
            "password" => "password"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("email");
    }
    /**
     * @test
     */
    public function check_if_request_incorrect_password()
    {
        $client = Client::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            "email" => $client->email,
            "password" => "password1"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("email");
    }
    /**
     * @test
     */
    public function check_if_request_incorrect_credentials()
    {
        $client = Client::factory()->create();
        $response = $this->postJson(route('api.clients.login'),[
            "email" => $client->email."12",
            "password" => "password1"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("email");
    }
}
