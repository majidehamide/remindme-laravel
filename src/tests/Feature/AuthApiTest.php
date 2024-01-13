<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class AuthApiTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
       
        
    }
    /**
     * A basic feature test example.
     */
    public function test_register():void
    {
        $password = $this->faker->password;
        $userData = [
            "name" => $this->faker->firstName,
            "email" =>  $this->faker->email,
            "password" => $password,
            "password_confirmation" => $password
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=>[
                    "user"=> [
                        "id",
                        "name",
                        "email",
                    ],
                    "access_token",
                    "refresh_token"
                ]
            ]);
    }

    public function test_login():void
    {

        $userData = [
            "email" =>  "alice@mail.com",
            "password" =>  "123456",
        ];

        $this->json('POST', 'api/session', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=>[
                    "user"=> [
                        "id",
                        "name",
                        "email"
                    ],
                    "access_token",
                    "refresh_token"
                ]
            ]);
    }

    public function test_referes_token():void
    {   
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-refresh']
        );

        $this->json('PUT', 'api/session',[], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=>[
                    "access_token",
                   
                ]
            ]);
    }
}
