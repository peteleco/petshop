<?php

use App\ValueObjects\Payment\CreditCard;

it('transform to json schema', function () {
    // dd(BankTransfer::jsonSchema());
    expect(CreditCard::jsonSchema())->toMatchSnapshot();
});
