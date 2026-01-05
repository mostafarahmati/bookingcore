<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Validation\ValidationException;

class ReservationService
{
    public function __construct(
        protected DatabaseManager $db,
        protected CacheRepository $cache
    ) {
    }

    /**
     * Create a new reservation with caching for reservation count.
     */
    public function createReservation(int $eventId, int $userId): Reservation
    {
        return $this->db->transaction(function () use ($eventId, $userId) {
            $event = Event::lockForUpdate()->findOrFail($eventId);

            // Use cache to store current reservation count
            $cacheKey = "event:{$event->id}:reservations_count";

            $currentReservations = $this->cache->remember($cacheKey, 60, function () use ($event) {
                return $event->reservations()->count();
            });

            if ($currentReservations >= $event->capacity) {
                throw ValidationException::withMessages([
                    'event_id' => 'This event is fully booked.',
                ]);
            }

            // Check for duplicate reservation (must query DB directly)
            $hasExisting = Reservation::where('user_id', $userId)
                ->where('event_id', $event->id)
                ->exists();

            if ($hasExisting) {
                throw ValidationException::withMessages([
                    'event_id' => 'You have already reserved a spot for this event.',
                ]);
            }

            $reservation = Reservation::create([
                'user_id' => $userId,
                'event_id' => $event->id,
            ]);

            // Invalidate cache after successful reservation
            $this->cache->forget($cacheKey);

            return $reservation;
        });
    }

    /**
     * Cancel a reservation and invalidate the related cache.
     */
    public function cancelReservation(Reservation $reservation, int $userId): bool
    {
        if ($reservation->user_id !== $userId) {
            throw ValidationException::withMessages([
                'reservation' => 'You are not authorized to cancel this reservation.',
            ]);
        }

        $eventId = $reservation->event_id;
        $deleted = (bool) $reservation->delete();

        if ($deleted) {
            // Invalidate reservation count cache
            $this->cache->forget("event:{$eventId}:reservations_count");
        }

        return $deleted;
    }

    /**
     * Get available spots for an event using cache.
     */
    public function getAvailableSpots(Event $event): int
    {
        $cacheKey = "event:{$event->id}:reservations_count";

        $reserved = $this->cache->remember($cacheKey, 60, function () use ($event) {
            return $event->reservations()->count();
        });

        return max(0, $event->capacity - $reserved);
    }

    /**
     * Force refresh the reservation count cache for an event (useful for admin or debugging)
     */
    public function refreshReservationCountCache(int $eventId): void
    {
        $this->cache->forget("event:{$eventId}:reservations_count");
    }
}
