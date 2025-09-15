<?php

namespace App\Http\Requests;

use App\Rules\BookingTimeRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'table_id' => ['required', 'exists:tables,id'],
            'date' => 'required|date|after_or_equal:today',
            'time' => ['required', 'date_format:H:i'],
            'notes' => 'nullable|string|max:500'
        ];
    }
}
