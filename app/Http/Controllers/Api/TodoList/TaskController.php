<?php

namespace App\Http\Controllers\Api\TodoList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Http\Requests\Api\Task\DeleteTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Task\CreateTaskService;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\GetTaskByQueryService;
use App\Services\Task\UpdateTaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Get tasks by query url
     *
     * @return HttpResponse
     */
    public function index(Request $request)
    {
        $query = $request->query();
        $query['filters']['user_id'] = Auth::id();
        $result = resolve(GetTaskByQueryService::class)->setParams($query)->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.tasks.get_all_success')
            ]);
        }

        return $this->responseErrors(__('messages.tasks.get_all_fail'));
    }

    /**
     * Create task
     *
     * @param  Request $request
     * @return HttpResponse
     */
    public function store(CreateTaskRequest $request)
    {
        $result = resolve(CreateTaskService::class)->setParams([...$request->validated(), 'user_id' => Auth::id()])->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.tasks.create_success')
            ]);
        }

        return $this->responseErrors(__('messages.tasks.create_fail'));
    }

    /**
     * Update task
     *
     * @param  Request $request
     * @param  int $taskId
     * @return HttpResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = array_merge(['id' => $task['id']], $request->validated());
        $result = resolve(UpdateTaskService::class)->setParams($data)->handle();

        if ($result) {
            return $this->responseSuccess([
                'data' => $result,
                'message' => __('messages.tasks.update_success')
            ]);
        }

        return $this->responseErrors(__('messages.tasks.update_fail'));
    }

    /**
     * Delete task
     *
     * @param  int  $taskId
     * @return HttpResponse
     */
    public function destroy(DeleteTaskRequest $request, Task $task)
    {
        $result = resolve(DeleteTaskService::class)->setParams(['id' => $task['id']])->handle();

        if ($result) {
            return $this->responseSuccess([
                'message' => __('messages.tasks.delete_success')
            ]);
        }

        return $this->responseErrors(__('messages.tasks.delete_fail'));
    }
}