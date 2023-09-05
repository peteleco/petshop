<?php

namespace App\ValueObjects\Payment;

use Carbon\Carbon;
use ReflectionClass;
use ReflectionType;
use Spatie\LaravelData\Data;

abstract class PaymentDetail extends Data
{
    /**
     * @throws \Throwable
     */
    public static function jsonSchema(): string
    {
        $reflection = new ReflectionClass(static::class);
        /** @var array-key $schema*/
        $schema = [];
        $constructor = $reflection->getConstructor();
        throw_if(!$constructor, \Exception::class, __('Class without constructor.'));
        foreach ($constructor->getParameters() as $parameter) {
            $schema[$parameter->getName()] = static::parseType($parameter->getType());
        }

        return (string) json_encode($schema);
    }
    protected static function parseType(?ReflectionType $type): string
    {
        if(!$type || in_array($type, [Carbon::class, \DateTimeInterface::class])) {
            return 'string';
        }
        return $type;
    }
}
