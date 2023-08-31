<?php

namespace App\Http\Resources\Api\V1;

use Throwable;
use Spatie\LaravelData\Data;
use Illuminate\Http\JsonResponse;
use App\Transformers\TraceableTransformer;
use App\Transformers\EmptyArrayTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Transformers\ErrorValidationTransformer;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorResource extends Data
{
    public function __construct(
        public readonly int $success = 0,
        #[WithTransformer(EmptyArrayTransformer::class, true)]
        public readonly bool $data = false,
        public readonly string $error = 'Something went wrong.',
        #[WithTransformer(ErrorValidationTransformer::class)]
        public readonly ValidationException|bool $errors = false,
        #[MapOutputName('trace')]
        #[WithTransformer(TraceableTransformer::class)]
        public readonly Throwable|bool $exception = false,
    ) {
    }

    public static function fromAuthenticationException(
        AuthenticationException $exception,
        bool $debug = false
    ): JsonResponse {
        return (new self())->toJsonResponse(ResponseAlias::HTTP_UNAUTHORIZED, $exception, $debug);
    }

    public static function fromHttpException(HttpExceptionInterface $exception, bool $debug = false): JsonResponse
    {
        return (new self())->toJsonResponse($exception->getStatusCode(), $exception, $debug);
    }

    public static function fromValidationException(ValidationException $exception, bool $debug = false): JsonResponse
    {
        return static::from([
            'errors' => $exception,
        ])->toJsonResponse(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $exception, $debug);
    }

    public function toJsonResponse(int $statusCode, Throwable $throwable, bool $debug = false): JsonResponse
    {
        return (new JsonResponse(
            $this->additional([
                'error' => $throwable->getMessage(),
                'exception' => $debug ? $throwable : null,
            ])
        ))->setStatusCode($statusCode);
    }
}
