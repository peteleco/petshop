<?php

namespace App\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class ErrorValidationTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): mixed
    {
        if ($property->isReadonly && $value instanceof \Illuminate\Validation\ValidationException) {
            return $value->errors();
        }

        return [];
    }
}
