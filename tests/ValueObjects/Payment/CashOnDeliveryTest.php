<?php

use App\ValueObjects\Payment\CashOnDelivery;

it('transform to json schema', function (){
    expect(CashOnDelivery::jsonSchema())->toMatchSnapshot();
});
