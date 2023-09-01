<?php

namespace App\Contracts\Builders;

use App\Contracts\Http\Requests\FilterRequestObject;

interface Filterable
{
    public function filterBy(FilterRequestObject $filters): static;
}
