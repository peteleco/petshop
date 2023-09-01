<?php

namespace App\Builders;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Str;
use App\Contracts\Builders\Filterable;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Http\Requests\FilterRequestObject;

/**
 * @extends Builder<\Illuminate\Database\Eloquent\Model>
 */
abstract class FilterBuilder extends Builder implements Filterable
{
    /**
     * findBy: find by specific value
     * filterBy: filter by value
     * search..By: search something and return collection
     *
     * @return $this
     */
    public function filterBy(FilterRequestObject $filters): static
    {
        $reflect = new ReflectionClass($filters);
        $attributes = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        // sort by(asc|desc)?
        foreach ($attributes as $attribute) {
            $filterMethod = 'filterBy' . Str::camel($attribute->getName());
            // Check if method exists and if the attribute is != null
            if (method_exists($this, $filterMethod) && $filters->{$attribute->getName()} !== null) {
                $this->{$filterMethod}($filters->{$attribute->getName()});
            }
        }
        if ($filters->sortBy() !== null) {
            $this->sortBy($filters->sortBy(), $filters->desc());
        }

        return $this;
    }

    public function sortBy(string $attribute, bool $desc = false): static
    {
        if ($desc) {
            return $this->orderByDesc($attribute);
        }

        return $this->orderBy($attribute);
    }
}
