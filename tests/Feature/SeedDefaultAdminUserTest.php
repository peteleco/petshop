<?php

use App\Models\User;

it('ensure that the default admin user was created', function () {
    expect(User::query()->where('email', 'admin@buckhill.co.uk')->count())
        ->toBe(1);
});
