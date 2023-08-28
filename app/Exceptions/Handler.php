<?php

namespace App\Exceptions;

use App\Http\Resources\Api\V1\ErrorResource;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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

    public function __construct(Container $container, protected readonly \Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($container);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Exception $exception, Request $request) {
            // Format JSON Response
            if ($request->is('api/*')) {
                /** @var \Illuminate\Validation\ValidationException $exception */
                if ($exception instanceof \Illuminate\Validation\ValidationException) {
                    return ErrorResource::from([
                        'error' => $exception->getMessage(),
                        'errors' => $exception->errors(),
                        'trace' => $this->app->hasDebugModeEnabled()? $exception->getTrace() : []
                    ])->toResponse($request)
                        ->setStatusCode($exception->status);
                }
                /** @var HttpExceptionInterface $exception */
                if($this->isHttpException($exception)) {
                    return ErrorResource::from([
                        'error' => $exception->getMessage(),
                        'trace' => $this->app->hasDebugModeEnabled()? $exception->getTrace() : []
                    ])->toResponse($request)
                        ->setStatusCode($exception->getStatusCode());
                }
            }
        });
    }
}
