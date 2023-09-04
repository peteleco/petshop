<?php

namespace App\ValueObjects\Payment;

use App\ValueObjects\Payment\PaymentDetail;

class BankTransfer extends PaymentDetail
{
    public function __construct(
        public readonly string $swift,
        public readonly string $iban,
        public readonly string $name,
    ) {
    }
}