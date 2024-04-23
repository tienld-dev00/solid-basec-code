<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handle response errors
     * 
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function responseErrors($message = '', $statusCode = Response::HTTP_FORBIDDEN)
    {
        return response()->json([
            'code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Handle response success
     * 
     * @param $data
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function responseSuccess($data, $statusCode = Response::HTTP_OK)
    {
        return response()->json(
            array_merge(['code' => $statusCode], $data),
            $statusCode
        );
    }
}
