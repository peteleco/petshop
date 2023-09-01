<?php

namespace App\Contracts\Builders;

use App\Contracts\Http\Requests\FilterRequestObject;

interface Filterable
{
    public function filterBy(FilterRequestObject $filters): self;

    public function sortBy(string $attribute, bool $desc = false): self;
}
