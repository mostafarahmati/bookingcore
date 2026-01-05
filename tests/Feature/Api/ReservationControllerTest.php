<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_reservations()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        Reservation::factory(3)->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/my-reservations');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_reservation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $event = Event::factory()->create(['capacity' => 10]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/reservations', ['event_id' => $event->id]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reservations', ['event_id' => $event->id]);
    }

    public function test_store_fails_validation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/reservations', ['event_id' => 999]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['event_id']);
    }

    public function test_destroy_cancels_reservation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Reservation cancelled successfully']);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_destroy_fails_unauthorized()
    {
        $user1 = User::factory()->create();
        $token = $user1->createToken('test')->plainTextToken;
        $reservation = Reservation::factory()->create(['user_id' => User::factory()->create()->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(400)
            ->assertJson(['error' => 'You are not authorized to cancel this reservation.']);
    }
}
