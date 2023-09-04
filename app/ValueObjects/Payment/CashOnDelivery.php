<?php

namespace App\ValueObjects\Payment;

use App\ValueObjects\Payment\PaymentDetail;

class CashOnDelivery extends PaymentDetail
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $address,
    )
    {
    }
}