<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_events()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        Event::factory(5)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_show_returns_single_event()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $event = Event::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $event->id]);
    }

    public function test_unauthenticated_fails()
    {
        $response = $this->getJson('/api/events');

        $response->assertStatus(401);
    }
}
