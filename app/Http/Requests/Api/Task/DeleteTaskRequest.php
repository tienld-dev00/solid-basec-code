<?php

namespace App\Http\Requests\Api\Task;

use App\Http\Requests\BaseRequest;

class DeleteTaskRequest extends BaseRequest
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
}
