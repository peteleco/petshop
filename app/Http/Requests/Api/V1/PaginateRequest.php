<?php

namespace App\Http\Requests\Api\V1;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Nullable;

class PaginateRequest extends Data
{
    public function __construct(
        #[Nullable]
        public readonly int|null $page = null,
        #[Nullable]
        public readonly int|null $limit = 10
    ) {
    }
}
