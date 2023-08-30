<?php

namespace App\Contracts\Concerns;

use Spatie\LaravelData\Contracts\DataObject;

interface FillableData
{
    public function fillFromData(DataObject $data): static;
}
