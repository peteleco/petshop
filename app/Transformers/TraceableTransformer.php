<?php

namespace App\Transformers;

use Throwable;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class TraceableTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): mixed
    {
        if ($property->isReadonly && $value instanceof Throwable) {
            return $value->getTrace();
        }

        return [];
    }
}
