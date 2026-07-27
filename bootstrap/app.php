<?php

use App\Http\Middleware\CheckPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // Feature/action based permission checks (ported from dharun_agni),
        // e.g. Route::middleware('permission:Dealer,view').
        $middleware->alias([
            'permission' => CheckPermission::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {

        // Never leak SQL errors, stack traces, or controller internals to the
        // browser. AJAX/JSON requests always get a short, generic message;
        // validation errors (422) still return their field-level messages so
        // the AJAX form handler can show them inline.
        $exceptions->render(function (\Throwable $e, Request $request) {

            if (! $request->expectsJson() && ! $request->ajax()) {
                return null; // let Laravel render its normal HTML error page for full page loads
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Your session has expired. Please log in again.',
                ], 401);
            }

            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'The requested resource was not found.',
                ], 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'This action is not allowed.',
                ], 405);
            }

            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
                return response()->json([
                    'message' => $status === 403
                        ? 'You do not have permission to perform this action.'
                        : 'Something went wrong. Please try again.',
                ], $status);
            }

            // Anything else (SQL errors, unexpected exceptions, etc.) -> generic 500.
            return response()->json([
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        });

    })

    ->create();
