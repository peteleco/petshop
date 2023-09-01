<?php

namespace App\Http\Resources\Api\V1;

use Throwable;
use Spatie\LaravelData\Data;
use Illuminate\Http\JsonResponse;
use App\Transformers\TraceableTransformer;
use App\Transformers\EmptyArrayTransformer;
use Spatie\LaravelData\Contracts\DataObject;
use Symfony\Component\HttpFoundation\Response;
use App\Transformers\ErrorValidationTransformer;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Contracts\DataCollectable;
use Spatie\LaravelData\Attributes\WithTransformer;

class SuccessResource extends Data
{
    public function __construct(
        public readonly int $success = 1,
        #[WithTransformer(EmptyArrayTransformer::class)]
        public readonly ?DataObject $data = null,
        public readonly string $error = '',
        #[WithTransformer(ErrorValidationTransformer::class)]
        public readonly \Illuminate\Validation\ValidationException|bool $errors = false,
        #[MapOutputName('trace')]
        #[WithTransformer(TraceableTransformer::class)]
        public readonly Throwable|bool $exception = false,
    ) {
    }

    public static function ok(DataObject|DataCollectable $data): \Illuminate\Http\JsonResponse
    {
        if ($data instanceof DataCollectable) {
            return (new JsonResponse($data))->setStatusCode(Response::HTTP_OK);
        }
        return (new JsonResponse(
            static::from(['data' => $data])
        ))->setStatusCode(Response::HTTP_OK);
    }

    public static function created(DataObject $data): JsonResponse
    {
        return (new JsonResponse(
            static::from(['data' => $data])
        ))->setStatusCode(Response::HTTP_CREATED);
    }
}
