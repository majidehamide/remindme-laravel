<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserReminder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserReminderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_user_reminder_by_id(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-access']
        );

        $UserReminder = UserReminder::factory()->create();
        $this->json('GET', 'api/reminders/'.$UserReminder->id,[], ['Accept' => 'application/json'])
        ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=> [
                    "id",
                    "title",
                    "description", 
                    "remind_at",
                    "event_at"
                ]
            
            ]);
    }

    public function test_get_user_reminder(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-access']
        );

        $this->json('GET', 'api/reminders',[], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=> [
                    "reminders",
                    "limit",
                    "current_page",
                    "total_page"
                ]
            
            ]);

    }

    public function test_create_user_reminder(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-access']
        );
        $UserReminder = UserReminder::factory()->create();

        $this->json('PUT', 'api/reminders/'.$UserReminder->id,$UserReminder->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=> [
                    "id",
                    "title",
                    "description", 
                    "remind_at",
                    "event_at"
                ]
            
            ]);

    }

    public function test_update_user_reminder(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-access']
        );
        $payloads = [
            'user_id'=>1,
            'title' => fake()->text,
            'description' => fake()->text,
            'event_at' => now()->addSeconds(2)->timestamp,
            'remind_at' => now()->addSeconds(2)->timestamp, // password
        ];

        $this->json('POST', 'api/reminders',$payloads, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
                "data"=> [
                    "id",
                    "title",
                    "description", 
                    "remind_at",
                    "event_at"
                ]
            
            ]);

    }

    public function test_delete_user_reminder(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['token-access']
        );
        $UserReminder = UserReminder::factory()->create();
        $this->json('DELETE', 'api/reminders/'. $UserReminder->id,[], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "ok",
            
            ]);

    }
}
