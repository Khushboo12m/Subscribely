<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


      public function render($request, Throwable $exception)
    {
        // ✅ Return JSON response for API routes
        if ($request->is('api/*')) {

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'API endpoint not found.'
                ], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'HTTP method not allowed for this route.'
                ], 405);
            }

            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested resource not found.'
                ], 404);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            if ($exception instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof HttpResponseException) {
                return $exception->getResponse();
            }

            // Fallback for any other unhandled error
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        // Non-API routes will use the default error pages
        return parent::render($request, $exception);
    }
}
