<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:rfc',
            'password' => 'required|string'
        ];
    }

    public function withValidator(Validator $validator): void {
        $validator->after(function ($validator) {
            $user = User::query()
                ->where('email', $this->validated('email'))
                ->whereNotNull('app_registered_at')
                ->first();

            if ($user !== null) {
                $validator->errors()->add('email', 'Email Already registered');
            }
        });
    }
}
