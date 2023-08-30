<?php

namespace App\Http\Resources\Api\V1;

use Throwable;
use Spatie\LaravelData\Data;
use App\Transformers\TraceableTransformer;
use App\Transformers\EmptyArrayTransformer;
use App\Transformers\ErrorValidationTransformer;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;

class ErrorResource extends Data
{
    public function __construct(
        public readonly int $success = 0,
        #[WithTransformer(EmptyArrayTransformer::class, true)]
        public readonly bool $data = false,
        public readonly string $error = 'Something went wrong.',
        #[WithTransformer(ErrorValidationTransformer::class)]
        public readonly \Illuminate\Validation\ValidationException|bool $errors = false,
        #[MapOutputName('trace'),
            WithTransformer(TraceableTransformer::class)]
        public readonly  Throwable|bool $exception = false,
    ) {
    }
}
