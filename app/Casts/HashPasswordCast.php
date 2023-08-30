<?php

namespace App\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;
use App\Exceptions\Casts\InvalidTypeForPasswordCast;

class HashPasswordCast implements Cast
{
    /**
     * @throws \Throwable
     * @param array<array-key> $context
     * @inheritdoc
     */
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        throw_if(
            !$property->type->acceptsType('string'),
            InvalidTypeForPasswordCast::class,
            __('Only strings can be casted.')
        );
        return \Hash::make($value);
    }
}
