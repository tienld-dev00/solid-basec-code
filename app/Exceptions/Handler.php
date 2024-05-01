<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response as HttpResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Custom handle error
     * 
     * @param mixed $request
     * @param Throwable $th
     * 
     * @return HttpResponse
     */
    public function render($request, Throwable $th)
    {
        if ($th instanceof ModelNotFoundException) {
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => __('httpStatusMessage.not_found')
            ], Response::HTTP_NOT_FOUND);
        }

        if ($th instanceof AuthorizationException) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => __('auth.unauthorized')
            ], Response::HTTP_UNAUTHORIZED);
        }

        return parent::render($request, $th);
    }
}
