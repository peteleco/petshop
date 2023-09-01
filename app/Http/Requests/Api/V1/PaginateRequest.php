<?php

namespace App\Http\Requests\Api\V1;

use Spatie\LaravelData\Data;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\Validation\Nullable;

class PaginateRequest extends Data
{
    public function __construct(
        #[Nullable]
        public readonly Optional|int|null $page = null,
        #[Nullable]
        public readonly Optional|int|null $limit = 10
    ) {
    }
}
