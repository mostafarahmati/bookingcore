<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Event Reservation System API Documentation",
 *     description="A complete event reservation system built with Laravel 11, Sanctum authentication, and Filament admin panel.<br><br>
 *     This documentation explains all API endpoints in English and allows direct testing.",
 *     @OA\Contact(
 *         email="support@example.com",
 *         name="Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Local development server"
 * )
 *
 * @OA\Server(
 *     url="https://api.yourproduction.com",
 *     description="Production server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="sanctum",
 *     description="Enter your Sanctum token in Bearer <token> format"
 * )
 *
 * @OA\Schema(
 *     schema="Event",
 *     type="object",
 *     title="Event",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Music Concert"),
 *     @OA\Property(property="description", type="string", example="Live concert featuring popular singer"),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2026-02-01T19:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2026-02-01T22:00:00Z"),
 *     @OA\Property(property="capacity", type="integer", example=100),
 *     @OA\Property(property="reservations_count", type="integer", example=45, description="Current number of reservations"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Reservation",
 *     type="object",
 *     title="Reservation",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=5),
 *     @OA\Property(property="event_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="event",
 *         ref="#/components/schemas/Event"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     @OA\Property(property="id", type="integer", example=5),
 *     @OA\Property(property="name", type="string", example="Ali Ahmadi"),
 *     @OA\Property(property="email", type="string", format="email", example="ali@example.com"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Definitions
{
}
