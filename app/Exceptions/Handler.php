<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\ErrorResource;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     * @inheritdoc
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function __construct(
        Container $container,
        protected readonly \Illuminate\Contracts\Foundation\Application $app
    ) {
        parent::__construct($container);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Throwable $exception, Request $request) {
            // Format JSON Response
            if ($request->is('api/*')) {
                if ($exception instanceof \Illuminate\Validation\ValidationException) {
                    return ErrorResource::from([

                        'error' => $exception->getMessage(),
                        'errors' => $exception,
                        'exception' => $this->app->hasDebugModeEnabled() ? $exception : null,
                    ])->toResponse($request)
                        ->setStatusCode($exception->status);
                }

                if ($this->isHttpException($exception) && $exception instanceof HttpExceptionInterface) {
                    return ErrorResource::from([
                        'error' => $exception->getMessage(),
                        'exception' => $this->app->hasDebugModeEnabled() ? $exception : null,
                    ])->toResponse($request)
                        ->setStatusCode($exception->getStatusCode());
                }
            }
        });
    }
}
