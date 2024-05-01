<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'regex:/^\S*$/'
            ],
        ];
    }
}
