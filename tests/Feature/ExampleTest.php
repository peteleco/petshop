<?php

use function Pest\Laravel\{get};

it('test the application returns a successful response', function () {
    get('/')->assertStatus(200);
});
