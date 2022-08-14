<?php

namespace Tests\Feature\Api\Auth\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_register_a_new_user()
    {
        $response = $this->postJson(route("api.users.register"),[
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => "123456789",
            'password_confirmation' => "123456789",
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
    public function cannot_register_a_new_user_if_exists()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route("api.users.register"),[
            'name' => $user->name,
            'email' => $user->email,
            'password' => "password",
            'password_confirmation' => "password",
        ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors("email");
    }
    /**
     * @test
     */
    public function cannot_register_a_new_user_if_password_is_must_minus_eight_character()
    {
        $response = $this->postJson(route("api.users.register"),[
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => "passwor",
            'password_confirmation' => "passwor",
        ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors("password");
    }
    /**
     * @test
     */
    public function cannot_register_a_new_user_if_password_is_not_confirmed()
    {
        $response = $this->postJson(route("api.users.register"),[
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => "password",
        ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors("password");
    }
    /**
     * @test
     */
    public function cannot_register_a_new_user_if_email_not_contain_format()
    {
        $response = $this->postJson(route("api.users.register"),[
            'name' => fake()->name(),
            'email' => fake()->name(),
            'password' => "password",
        ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors("password");
    }
    /**
     * @test
     */
    public function cannot_register_a_new_user_if_name_is_minus_of_three_characters()
    {
        $response = $this->postJson(route("api.users.register"),[
            'name' => 'Io',
            'email' => fake()->name(),
            'password' => "password",
        ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors("name");
    }
}
