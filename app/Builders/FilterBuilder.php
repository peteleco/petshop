<?php

namespace App\Builders;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Str;
use App\Contracts\Builders\Filterable;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Http\Requests\FilterRequestObject;

/**
 * @template TModelClass of \Illuminate\Database\Eloquent\Model
 * @extends Builder<TModelClass>
 */
abstract class FilterBuilder extends Builder implements Filterable
{
    /**
     * @return \App\Builders\FilterBuilder<TModelClass>
     */
    public function filterBy(FilterRequestObject $filters): self
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
            return $this->sortBy($filters->sortBy(), $filters->desc());
        }

        return $this;
    }

    /**
     * @return \App\Builders\FilterBuilder<TModelClass>
     */
    public function sortBy(string $attribute, bool $desc = false): self
    {
        if ($desc) {
            $this->orderByDesc($attribute);

            return $this;
        }

        $this->orderBy($attribute);

        return $this;
    }
}
