<?php

namespace App\Http\Requests\Api\User;

use App\Enums\UserRole;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
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
                'string',
                'between:6,100',
            ],
            'email' => [
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                'unique:users,email,' . $this->user->id
            ],
            'password' => [
                'string',
                'min:8',
                'max:50',
                'regex:/^\S*$/'
            ],
            'role' => [
                Rule::prohibitedIf($this->user()->role !== UserRole::ADMIN),
                'integer',
                Rule::in(UserRole::getValues())
            ],
        ];
    }
}
