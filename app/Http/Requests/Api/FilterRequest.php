<?php

namespace App\Http\Requests\Api;

use Spatie\LaravelData\Data;
use App\Contracts\Http\Requests\FilterRequestObject;

abstract class FilterRequest extends Data implements FilterRequestObject
{
}
