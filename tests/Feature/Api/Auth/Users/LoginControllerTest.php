<?php

namespace Tests\Feature\Api\Auth\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function check_if_login_success_with_correct_request()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/users/login',[
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                "token",
                "user"
            ]
        ]);
    }
    /**
     * @test
     */
    public function check_required_email()
    {
        // $user = User::factory()->create();
        $response = $this->postJson('/api/users/login',[
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
        $user = User::factory()->create();
        $response = $this->postJson('/api/users/login',[
            "email" => $user->email,
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
        $response = $this->postJson('/api/users/login',[
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
        $user = User::factory()->create();
        $response = $this->postJson('/api/users/login',[
            "email" => $user->email,
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
        $user = User::factory()->create();
        $response = $this->postJson('/api/users/login',[
            "email" => $user->email."12",
            "password" => "password1"
        ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors("email");
    }
}
