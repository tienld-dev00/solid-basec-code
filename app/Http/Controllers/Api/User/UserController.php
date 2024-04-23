<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Interfaces\User\UserRepositoryInterface;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\GetUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Get a listing of the user.
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
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * Get the specified user.
     *
     * @param  int  $id
     * @return HttpResponse
     */
    public function show($id)
    {
        try {
            $user = resolve(UserRepositoryInterface::class)->find($id);

            return $this->responseSuccess([
                'user' => $user,
                'message' => __('users.get_success')
            ]);
        } catch (\Exception $e) {
            Log::error($e);

            return $this->responseErrors(__('users.get_fail'));
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return HttpResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $input = array_merge(['id' => $id], $request->validated());
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
     * Remove the specified user from storage.
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
