<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\{getJson,actingAs};

it('list all non admin users', function () {
    $totalOfNonAdminUsers = User::query()->filterByNotAdmin()->count();
    $totalAdminUsers = User::query()->filterByAdmin()->count();
    $totalUsers = User::query()->count();
    $admin = User::factory()->admin()->create();
    $response = actingAs($admin,'api')->getJson(route('api.v1.admin.user_listing'));
    $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
        'data',
        'links',
        'meta'
    ])->assertJsonPath('meta.total', $totalOfNonAdminUsers);
    expect($totalAdminUsers + $totalOfNonAdminUsers)->toBe($totalUsers);
});

it('ensure uses user list request on controller', function () {
    $this->assertInvokedControllerUsesDataObjectOnRequest(
        \App\Http\Controllers\Api\V1\Admin\UserListController::class,
        \App\Http\Requests\Api\V1\Admin\UserListRequest::class
    );
});

it('ensure uses pagination request on controller', function () {
    $this->assertInvokedControllerUsesDataObjectOnRequest(
        \App\Http\Controllers\Api\V1\Admin\UserListController::class,
        \App\Http\Requests\Api\V1\PaginateRequest::class
    );
});


