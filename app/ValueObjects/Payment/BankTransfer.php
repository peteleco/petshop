<?php

namespace App\ValueObjects\Payment;

class BankTransfer extends PaymentDetail
{
    public function __construct(
        public readonly string $swift,
        public readonly string $iban,
        public readonly string $name,
    ) {
    }
}
