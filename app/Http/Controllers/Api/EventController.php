<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;

/**
 * @OA\Tag(
 *     name="Events",
 *     description="Operations for viewing events"
 * )
 */
class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     tags={"Events"},
     *     summary="List all events",
     *     description="Get a list of all events with the current number of reservations",
     *     operationId="getEventsList",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Events retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Event"))
     *     )
     * )
     */
    public function index()
    {
        $events = Event::withCount('reservations')->get();

        return response()->json($events);
    }

    /**
     * @OA\Get(
     *     path="/api/events/{event}",
     *     tags={"Events"},
     *     summary="Get event details",
     *     description="Retrieve full information about a specific event",
     *     operationId="getEventById",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(response=404, description="Event not found")
     * )
     */
    public function show(Event $event)
    {
        $event->loadCount('reservations');

        return response()->json($event);
    }
}
