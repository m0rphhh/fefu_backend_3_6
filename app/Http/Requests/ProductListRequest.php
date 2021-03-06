<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_slug' => 'sometimes|string',
            'sort' => ['nullable', Rule::in(['price_asc', 'price_desc'])],
            'filters' => 'nullable|array',
            'filters.*' => 'required|array'
        ];
    }
}
