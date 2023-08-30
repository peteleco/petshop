<?php

namespace App\Transformers;

use Spatie\LaravelData\Contracts\DataObject;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class EmptyArrayTransformer implements Transformer
{
    public function __construct(
        protected readonly bool $force = false
    ) {
    }

    public function transform(DataProperty $property, mixed $value): mixed
    {
        if ($property->isReadonly && $value instanceof DataObject === false) {
            return [];
        }

        return $value;
    }
}
