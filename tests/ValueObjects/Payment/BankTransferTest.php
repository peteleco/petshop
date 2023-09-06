<?php

use App\ValueObjects\Payment\BankTransfer;

it('transform to json schema', function () {
    // dd(BankTransfer::jsonSchema());
    expect(BankTransfer::jsonSchema())->toMatchSnapshot();
});
