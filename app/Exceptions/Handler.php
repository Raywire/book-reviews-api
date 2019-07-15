<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $statusCode404 = 404;
        $statusCode400 = 400;
        $statusCode401 = 401;
        $statusCode500 = 500;

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found'
            ], $statusCode404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Page not found'
            ], $statusCode404);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], $statusCode401);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => $exception->errors()
            ], $statusCode400);
        }

        dd($exception);
        return response()->json([
            'error' => 'Error'
        ], $statusCode500);
    }
}
