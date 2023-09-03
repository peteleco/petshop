<?php

use App\Http\Requests\Api\V1\Admin\LoginRequest;

it('verifies validation rules', function () {
    $rules = LoginRequest::getValidationRules([]);
    $this->assertExactValidationRules([
        'email' => ['string', 'required', 'email:rfc'],
        'password' => ['string', 'required'],
    ], $rules);
});
