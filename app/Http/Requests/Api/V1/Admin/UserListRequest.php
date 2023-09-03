<?php

namespace App\Http\Requests\Api\V1\Admin;

use Carbon\Carbon;
use App\Http\Requests\Api\FilterRequest;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

class UserListRequest extends FilterRequest
{
    public function __construct(
        #[Nullable]
        #[Max(255)]
        public readonly string|null $first_name = null,
        #[Nullable]
        #[Max(255)]
        public readonly string|null $email = null,
        #[Nullable]
        #[Max(255)]
        #[MapOutputName('phone_number')]
        public readonly string|null $phone = null,
        #[Nullable]
        #[Max(255)]
        public readonly string|null $address = null,
        #[Nullable]
        #[DateFormat('Y-m-d')]
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public readonly Carbon|null $created_at = null,
        #[Nullable]
        #[BooleanType]
        public readonly bool|null $marketing = null,
        #[Nullable]
        #[In(['first_name', 'email', 'phone', 'address', 'created_at', 'marketing'])]
        public readonly string|null $sortBy = null,
        #[Nullable]
        #[BooleanType]
        public readonly bool $desc = false
    ) {
    }

    public function sortBy(): ?string
    {
        return $this->sortBy;
    }

    public function desc(): bool
    {
        return $this->desc;
    }
}
