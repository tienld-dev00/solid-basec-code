<?php

namespace App\Http\Requests\Api\TaskGroup;

use App\Http\Requests\BaseRequest;

class CreateTaskGroupRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }
}
