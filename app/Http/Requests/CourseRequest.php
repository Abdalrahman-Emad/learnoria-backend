<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'field' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'price' => 'required|numeric|min:0|max:999999.99',
            'duration' => 'required|integer|min:1|max:1000',
            'max_students' => 'nullable|integer|min:1|max:1000',
            'start_date' => 'nullable|date|after:today',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
