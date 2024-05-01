<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;

class CreateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'between:6,100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                'unique:users,email',
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
