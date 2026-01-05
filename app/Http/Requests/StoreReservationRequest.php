<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('sanctum')->check(); // فقط کاربر لاگین‌شده
    }

    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'integer',
                'exists:events,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'شناسه رویداد الزامی است.',
            'event_id.exists'   => 'رویداد موردنظر یافت نشد.',
        ];
    }
}
