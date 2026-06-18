<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'synopsis' => ['required', 'string'],
            'duration' => ['required', 'integer', 'min:1'],
            'poster' => ['sometimes', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'genre' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:now_showing,coming_soon'],
        ];
    }
}