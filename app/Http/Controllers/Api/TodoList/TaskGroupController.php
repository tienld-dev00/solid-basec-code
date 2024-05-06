<?php

namespace App\Http\Controllers\Api\TodoList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskGroup\CreateTaskGroupRequest;
use App\Http\Requests\Api\TaskGroup\DeleteTaskGroupRequest;
use App\Http\Requests\Api\TaskGroup\UpdateTaskGroupRequest;
use App\Models\TaskGroup;
use App\Services\TaskGroup\CreateTaskGroupService;
use App\Services\TaskGroup\DeleteTaskGroupService;
use App\Services\TaskGroup\GetTaskGroupByFieldService;
use App\Services\TaskGroup\UpdateTaskGroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskGroupController extends Controller
{
    /**
     * Get all task group by user_id
     *
     * @return HttpResponse
     */
    public function index()
    {
        $result = resolve(GetTaskGroupByFieldService::class)->setParams(['id' => Auth::id(), 'column' => 'user_id'])->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.task_groups.get_all_success')
            ]);
        }

        return $this->responseErrors(__('messages.task_groups.get_all_fail'));
    }

    /**
     * Create task group
     *
     * @param  Request $request
     * @return HttpResponse
     */
    public function store(CreateTaskGroupRequest $request)
    {
        $result = resolve(CreateTaskGroupService::class)
            ->setParams([...$request->validated(), 'user_id' => Auth::id()])
            ->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.task_groups.create_success')
            ], Response::HTTP_CREATED);
        }

        return $this->responseErrors(__('message.task_groups.create_fail'));
    }

    /**
     * Update task group
     *
     * @param  Request $request
     * @param  int $groupId
     * @return HttpResponse
     */
    public function update(UpdateTaskGroupRequest $request, TaskGroup $taskGroup)
    {
        $result = resolve(UpdateTaskGroupService::class)
            ->setParams([
                ...$request->validated(),
                'id' => $taskGroup->id
            ])
            ->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.task_groups.update_success')
            ]);
        }

        return $this->responseErrors(__('messages.task_groups.update_fail'));
    }

    /**
     * Delete task group by id
     *
     * @param  TaskGroup  $taskGroup
     * @return HttpResponse
     */
    public function destroy(DeleteTaskGroupRequest $request, TaskGroup $taskGroup)
    {
        $result = resolve(DeleteTaskGroupService::class)->setParams(['id' => $taskGroup['id']])->handle();

        if ($result) {
            return $this->responseSuccess([
                'message' => __('messages.task_groups.delete_success')
            ]);
        }

        return $this->responseErrors(__('messages.task_groups.delete_fail'));
    }
}
