<?php

namespace App\ValueObjects\Payment;

use Carbon\Carbon;

class CreditCard extends PaymentDetail
{
    public function __construct(
        public readonly string $holder_name,
        public readonly string $number,
        public readonly int $ccv,
        public readonly Carbon $expire_date
    )
    {
    }
}