<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Reservations",
 *     description="User reservation management"
 * )
 */
class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservationService)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/my-reservations",
     *     tags={"Reservations"},
     *     summary="List user's reservations",
     *     description="Retrieve all reservations for the current authenticated user",
     *     operationId="getMyReservations",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Reservation"))
     *     )
     * )
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()->with('event')->get();

        return response()->json($reservations);
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     tags={"Reservations"},
     *     summary="Reserve an event",
     *     description="Create a new reservation for the current user",
     *     operationId="createReservation",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"event_id"},
     *             @OA\Property(property="event_id", type="integer", example=1, description="Event ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(response=400, description="Event is full or already reserved")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        try {
            $reservation = $this->reservationService->createReservation(
                eventId: $request->event_id,
                userId: Auth::id()
            );

            return response()->json($reservation->load('event'), 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{reservation}",
     *     tags={"Reservations"},
     *     summary="Cancel a reservation",
     *     description="Delete a reservation owned by the current user",
     *     operationId="cancelReservation",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="Reservation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation cancelled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Reservation cancelled successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="You are not authorized to cancel this reservation")
     * )
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $this->reservationService->cancelReservation($reservation, Auth::id());

            return response()->json(['message' => 'Reservation cancelled successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }
}
