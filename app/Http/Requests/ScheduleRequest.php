<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'exists:movies,id'],
            'studio_id' => ['required', 'exists:studios,id'],
            'show_date' => ['required', 'date'],
            'start_time' => ['required'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}