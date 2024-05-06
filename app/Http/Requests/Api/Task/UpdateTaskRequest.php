<?php

namespace App\Http\Requests\Api\Task;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UpdateTaskRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id === $this->task->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:200',
                'min:1',
            ],
            'description' => [
                'nullable',
                'string',
                'max:4000',
            ],
            'is_completed' => [
                'boolean'
            ],
            'due_date' => [
                'nullable',
                'date',
                Rule::when(request('due_date') !== $this->task->due_date, 'after_or_equal:' . now()->format('Y-m-d H:i')),
            ],
            'group_id' => [
                'nullable',
                'integer',
                'exists:task_groups,id'
            ]
        ];
    }
}
