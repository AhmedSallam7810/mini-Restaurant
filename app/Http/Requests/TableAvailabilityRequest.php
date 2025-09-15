<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableAvailabilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'capacity' => 'sometimes|integer|min:1|max:20'
        ];
    }
}
