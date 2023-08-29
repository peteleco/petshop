<?php

use App\Http\Requests\Api\V1\Admin\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\{postJson};

it('logins admin', function (LoginRequest $request) {
    $response = postJson(
        route('api.v1.admin.login'),
        $request->toArray()
    );
    $response->assertStatus(Response::HTTP_OK);

    // $response->assertJsonStructure(\App\Http\Resources\Api\V1\ErrorResource::)
})->with([
    'seeded user' => fn () => LoginRequest::from([
        'email' => 'admin@buckhill.co.uk',
        'password' => 'admin',
    ]),
]);

it('fails to login', function (LoginRequest $request, int $statusCode) {
    $response = postJson(
        route('api.v1.admin.login'),
        $request->toArray()
    );
    $response->assertStatus($statusCode);
})->with([
    'seeded user with wrong password' => [
        fn () => LoginRequest::from([
            'email' => 'admin@buckhill.co.uk',
            'password' => 'admin-',
        ]),
        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
    ],
    'nonexistent user' => [
        fn () => LoginRequest::from([
            'email' => 'admin@buckhill.co.uk-',
            'password' => 'admin-',
        ]),
        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
    ],
    'existent user without admin credentials' => [
        fn () => LoginRequest::from([
            'email' => \App\Models\User::factory()->create()->email,
            'password' => 'userpassword',
        ]),
        'statusCode' => Response::HTTP_UNAUTHORIZED,
    ],
]);
