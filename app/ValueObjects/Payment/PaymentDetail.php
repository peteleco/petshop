<?php

namespace App\ValueObjects\Payment;

use Carbon\Carbon;
use ReflectionClass;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Transformers\DtoTransformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;

abstract class PaymentDetail extends Data
{
    public static function jsonSchema():string
    {
        $reflection = new ReflectionClass(static::class);
        /** @var array-key $schema*/
        $schema = [];
        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $schema[$parameter->getName()] = static::transformToStringType($parameter->getType()->getName());
        }

        return json_encode($schema);
    }
    private static function transformToStringType(string $type): string
    {
        if(in_array($type,[Carbon::class, \DateTimeInterface::class])) {
            return 'string';
        }
        return $type;
    }
}