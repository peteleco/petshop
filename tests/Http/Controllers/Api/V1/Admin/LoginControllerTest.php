<?php

use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\{postJson};

it('logins admin', function (string $email, string $password) {
    $response = postJson(
        route('api.v1.admin.login'),
        compact('email', 'password')
    );
    $response->assertStatus(Response::HTTP_OK);

    // $response->assertJsonStructure(\App\Http\Resources\Api\V1\ErrorResource::)
})->with([
    'seeded user' => fn () => [
        'email' => 'admin@buckhill.co.uk',
        'password' => 'admin',
    ],
]);

it('fails to login', function (string $email, string $password, int $statusCode) {
    $response = postJson(
        route('api.v1.admin.login'),
        compact('email', 'password')
    );
    $response->assertStatus($statusCode);
})->with([
    'seeded user with wrong password' => fn () => [
        'email' => 'admin@buckhill.co.uk',
        'password' => 'admin-',
        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
    ],
    'nonexistent user' => fn () => [
        'email' => 'admin@buckhill.co.uk-',
        'password' => 'admin-',
        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
    ],
    'existent user without admin credentials' => fn () => [
        'email' => \App\Models\User::factory()->create()->email,
        'password' => 'userpassword',
        'statusCode' => Response::HTTP_UNAUTHORIZED,
    ],
]);
