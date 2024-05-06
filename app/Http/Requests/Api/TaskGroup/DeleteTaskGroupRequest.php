<?php

namespace App\Http\Requests\Api\TaskGroup;

use App\Http\Requests\BaseRequest;

class DeleteTaskGroupRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id === $this->taskGroup->user_id;
    }
}
