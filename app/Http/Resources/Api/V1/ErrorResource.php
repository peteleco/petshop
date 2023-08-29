<?php

namespace App\Http\Resources\Api\V1;

use Spatie\LaravelData\Data;

class ErrorResource extends Data
{
    public function __construct(
        public readonly int $success = 0,
        public readonly string $error = 'Something went wrong.',
        public readonly array $data = [],
        public readonly array $errors = [],
        public readonly array $trace = [],
    ) {
    }
}
