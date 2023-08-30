<?php

use App\Http\Resources\Api\V1\Admin\CreateResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\{postJson};

it('create an admin user', function (User $user) {
    $response = postJson(
        route('api.v1.admin.create'),
        [
            ...$user->toArray(),
            'password_confirmation' => 'admin admin',
            'password' => 'admin admin',
        ]
    );
    $response->assertStatus(Response::HTTP_CREATED);
    $storedData = CreateResource::from(json_decode($response->getContent())->data);
    // ensure user was created
    expect(User::filterByUUid($storedData->uuid)->filterByAdmin()->exists())->toBeTrue();
    //Todo: ensure token is valid
    // Validates if password is admin

})->with([
    'admin inputs' => fn () => User::factory()->make(),
]);
