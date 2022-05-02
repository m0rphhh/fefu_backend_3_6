<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppealFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'phone' => ['nullable', 'regex:/(^([+]7|8)+\d{10}$)/i'],
            'email' => 'nullable|email:rfc',
            'message' => 'required|string|max:1000',
        ];
    }
}
