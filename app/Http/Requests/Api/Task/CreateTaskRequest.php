<?php

namespace App\Http\Requests\Api\Task;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Carbon;

class CreateTaskRequest extends BaseRequest
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
                'max:200'
            ],
            'description' => [
                'string',
                'max:4000',
            ],
            'is_completed' => [
                'boolean'
            ],
            'group_id' => [
                'nullable',
                'integer',
                'exists:task_groups,id'
            ],
            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i')
            ]
        ];
    }
}
