<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        $this->renderable(function (Throwable $exception, $request) {
            if ($exception instanceof ModelNotFoundException && $request->expectsJson()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            if ($exception instanceof NotFoundHttpException && $request->expectsJson()) {
                return Route::respondWithRoute('api.fallback');
            }

            if ($exception instanceof AuthorizationException && $request->expectsJson()) {
                return response()->json(['message' => $exception->getMessage()], $exception->getCode());
            }

            if ($exception instanceof AccessDeniedHttpException && $request->expectsJson()) {
                return response()->json(['message' => $exception->getMessage()], $exception->getStatusCode());
            }
        });
    }
}
