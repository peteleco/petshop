<?php

use App\Http\Resources\Api\V1\Admin\CreateResource;
use App\Models\JwtToken;
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
    expect(User::findByUUid($storedData->uuid)->filterByAdmin()->exists())
        ->toBeTrue()
        ->and(JwtToken::query()
            ->where('unique_id', $storedData->token)
            ->exists())->toBeTrue();

})->with([
    'admin inputs' => fn () => User::factory()->make(),
]);

it('ensure uses create request on controller', function () {
    $this->assertInvokedControllerUsesDataObjectOnRequest(
        \App\Http\Controllers\Api\V1\Admin\CreateController::class,
        \App\Http\Requests\Api\V1\Admin\CreateRequest::class
    );
});
