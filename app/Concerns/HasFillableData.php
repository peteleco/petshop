<?php

namespace App\Concerns;

use ReflectionClass;
use ReflectionProperty;
use Spatie\LaravelData\Contracts\DataObject;

trait HasFillableData
{
    public function fillFromData(DataObject $data): static
    {
        $reflect = new ReflectionClass($data);
        $attributes = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($attributes as $attribute) {
            $this->setAttribute($attribute->getName(), $data->{$attribute->getName()});
        }

        return $this;
    }
}
