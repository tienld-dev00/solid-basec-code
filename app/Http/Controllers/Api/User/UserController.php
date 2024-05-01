<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\FindUserByDataService;
use App\Services\User\GetUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Get all user
     *
     * @return HttpResponse
     */
    public function index()
    {
        $users = resolve(GetUserService::class)->handle();

        if ($users) {
            return $this->responseSuccess([
                'users' => $users,
                'message' => __('users.get_all_success')
            ]);
        }

        return $this->responseErrors(__('users.get_all_fail'));
    }

    /**
     * Create user
     *
     * @param  CreateUserRequest $request
     * @return HttpResponse
     */
    public function store(CreateUserRequest $request)
    {
        $user = resolve(CreateUserService::class)->setParams($request->validated())->handle();

        if ($user) {
            return $this->responseSuccess(
                [
                    'user' => $user,
                    'message' => __('users.create_success')
                ],
                Response::HTTP_CREATED
            );
        }

        return $this->responseErrors(__('users.create_fail'));
    }

    /**
     * Get user by id
     *
     * @param  int  $id
     * @return HttpResponse
     */
    public function show($id)
    {
        $data = ['column' => 'id', 'value' => $id];
        $result = resolve(FindUserByDataService::class)->setParams($data)->handle();
        if (count($result) === 0) {
            return $this->responseErrors(__('users.get_fail'));
        }

        return $this->responseSuccess([
            'user' => $result[0],
            'message' => __('users.get_success')
        ]);
    }

    /**
     * Update user
     *
     * @param  UpdateUserRequest $request
     * @param  User $user
     * @return HttpResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = array_merge(['id' => $user->id], $request->validated());
        $user = resolve(UpdateUserService::class)->setParams($input)->handle();

        if ($user) {
            return $this->responseSuccess([
                'user' => $user,
                'message' => __('users.update_success')
            ]);
        }

        return $this->responseErrors(__('users.update_fail'));
    }

    /**
     * Delete user
     *
     * @param  int  $id
     * @return HttpResponse
     */
    public function destroy($id)
    {
        $user = resolve(DeleteUserService::class)->setParams($id)->handle();

        if ($user) {
            return $this->responseSuccess(['message' => __('users.delete_success')]);
        }

        return $this->responseErrors(__('users.delete_fail'));
    }
}
