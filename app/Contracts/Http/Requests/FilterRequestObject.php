<?php

namespace App\Contracts\Http\Requests;

use Spatie\LaravelData\Contracts\DataObject;

interface FilterRequestObject extends DataObject
{
    public function sortBy(): ?string;

    public function desc(): bool;
}
