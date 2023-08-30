<?php

namespace App\Http\Resources\Api\V1\Admin;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class CreateResource extends Data
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $address,
        public readonly string $phone_number,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: DATE_ATOM)]
        public readonly Carbon $updated_at,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: DATE_ATOM)]
        public readonly Carbon $created_at,
        public readonly ?string $token = null,
    ) {
    }
}
