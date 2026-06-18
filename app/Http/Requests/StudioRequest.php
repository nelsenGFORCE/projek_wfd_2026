<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'studio_name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }
}