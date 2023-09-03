<?php


use App\Http\Requests\Api\V1\Admin\UserListRequest;

it('verifies validation rules', function () {

    expect(UserListRequest::validate([]))->toBeEmpty();
    $rulesWhenFilled = UserListRequest::getValidationRules(
        [
            'first_name' => false,
            'email' => false,
            'phone' => false,
            'address' => false,
            'created_at' => false,
            'marketing' => false,
            'sortBy' => false,
            'desc' => false,
        ]
    );

    $this->assertExactValidationRules([

        'first_name' => ['string', 'nullable', 'max:255'],
        'email' => ['string', 'nullable', 'email:rfc'],
        'phone' => ['string', 'nullable', 'max:255'],
        'address' => ['string', 'nullable', 'max:255'],
        'created_at' => ['nullable', 'date_format:Y-m-d'],
        'marketing' => ['nullable', 'boolean'],
        'sortBy' => [
            'string',
            'nullable',
            new \Illuminate\Validation\Rules\In([
                'first_name',
                'email',
                'phone',
                'address',
                'created_at',
                'marketing',
            ]),
        ],

        'desc' => ['nullable', 'boolean'],
    ], $rulesWhenFilled);
});
