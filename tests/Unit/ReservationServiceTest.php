<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ReservationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ReservationService::class);
    }

    public function test_create_reservation_success()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);

        $reservation = $this->service->createReservation($event->id, $user->id);

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_create_reservation_fails_when_full()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 1]);
        Reservation::factory()->create(['event_id' => $event->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('This event is fully booked.');

        $this->service->createReservation($event->id, $user->id);
    }

    public function test_create_reservation_fails_on_duplicate()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);
        Reservation::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You have already reserved a spot for this event.');

        $this->service->createReservation($event->id, $user->id);
    }

    public function test_cancel_reservation_success()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);

        $result = $this->service->cancelReservation($reservation, $user->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_cancel_reservation_fails_unauthorized()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user1->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You are not authorized to cancel this reservation.');

        $this->service->cancelReservation($reservation, $user2->id);
    }

    public function test_has_reservation()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Reservation::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

        $this->assertTrue($this->service->hasReservation($event->id, $user->id));
    }

    public function test_get_available_spots()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        Reservation::factory(3)->create(['event_id' => $event->id]);

        $available = $this->service->getAvailableSpots($event);

        $this->assertEquals(7, $available);
    }
}
