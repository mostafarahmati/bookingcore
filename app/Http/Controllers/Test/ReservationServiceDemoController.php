<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationService;

class ReservationServiceDemoController extends Controller
{
    protected ReservationService $service;

    public function __construct(ReservationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $results = [];

        $results[] = $this->testSuccessfulReservation();
        $results[] = $this->testEventFull();
        $results[] = $this->testDuplicateReservation();
        $results[] = $this->testCancelSuccess();
        $results[] = $this->testCancelUnauthorized();
        $results[] = $this->testAvailableSpots();

        return view('test.reservation-service', compact('results'));
    }

    private function testSuccessfulReservation()
    {
        $user = User::factory()->create(['name' => 'کاربر تست']);
        $event = Event::factory()->create(['title' => 'رویداد تست موفق', 'capacity' => 10]);

        try {
            $reservation = $this->service->createReservation($event->id, $user->id);
            return [
                'title' => 'رزرو موفق',
                'status' => 'success',
                'message' => "رزرو با موفقیت ایجاد شد (ID: {$reservation->id})",
                'details' => "کاربر: {$user->name} | رویداد: {$event->title} | ظرفیت باقی‌مانده: " . $this->service->getAvailableSpots($event)
            ];
        } catch (\Exception $e) {
            return ['title' => 'رزرو موفق', 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function testEventFull()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['title' => 'رویداد پر', 'capacity' => 2]);

        // پر کردن ظرفیت
        Reservation::factory(2)->create(['event_id' => $event->id]);

        try {
            $this->service->createReservation($event->id, $user->id);
            return ['title' => 'رویداد پر شده', 'status' => 'error', 'message' => 'رزرو انجام شد (خطا!)'];
        } catch (\Exception $e) {
            return [
                'title' => 'رویداد پر شده',
                'status' => 'success',
                'message' => 'سیستم درست عمل کرد: ' . $e->getMessage(),
                'details' => "ظرفیت: {$event->capacity} | رزرو شده: 2"
            ];
        }
    }

    private function testDuplicateReservation()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['title' => 'رزرو تکراری', 'capacity' => 10]);
        Reservation::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

        try {
            $this->service->createReservation($event->id, $user->id);
            return ['title' => 'رزرو تکراری', 'status' => 'error', 'message' => 'رزرو تکراری اجازه داده شد (خطا!)'];
        } catch (\Exception $e) {
            return [
                'title' => 'رزرو تکراری',
                'status' => 'success',
                'message' => 'سیستم درست عمل کرد: ' . $e->getMessage()
            ];
        }
    }

    private function testCancelSuccess()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);

        try {
            $result = $this->service->cancelReservation($reservation, $user->id);
            return [
                'title' => 'لغو رزرو موفق',
                'status' => 'success',
                'message' => $result ? 'رزرو با موفقیت لغو شد' : 'لغو ناموفق بود'
            ];
        } catch (\Exception $e) {
            return ['title' => 'لغو رزرو موفق', 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function testCancelUnauthorized()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user1->id]);

        try {
            $this->service->cancelReservation($reservation, $user2->id);
            return ['title' => 'لغو غیرمجاز', 'status' => 'error', 'message' => 'لغو غیرمجاز اجازه داده شد (خطا!)'];
        } catch (\Exception $e) {
            return [
                'title' => 'لغو غیرمجاز',
                'status' => 'success',
                'message' => 'سیستم درست عمل کرد: ' . $e->getMessage()
            ];
        }
    }

    private function testAvailableSpots()
    {
        $event = Event::factory()->create(['title' => 'ظرفیت باقی‌مانده', 'capacity' => 10]);
        Reservation::factory(4)->create(['event_id' => $event->id]);

        $available = $this->service->getAvailableSpots($event);

        return [
            'title' => 'محاسبه ظرفیت باقی‌مانده',
            'status' => 'success',
            'message' => "ظرفیت کل: {$event->capacity} | رزرو شده: 4 | باقی‌مانده: {$available}",
            'details' => $available == 6 ? 'محاسبه درست است' : 'محاسبه اشتباه است'
        ];
    }
}
