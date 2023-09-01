<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('info', \App\Http\Controllers\Api\V1\ApiInfoController::class)->name('api.v1.info');
// Admin
Route::post('admin/login', \App\Http\Controllers\Api\V1\Admin\LoginController::class)->name('api.v1.admin.login');
Route::post('admin/create', \App\Http\Controllers\Api\V1\Admin\CreateController::class)->name('api.v1.admin.create');

// Routes that must be authenticated
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:api', 'auth.admin'], // 'auth' => \App\Http\Middleware\Authenticate::class,
], function (): void {
    Route::get('user-listing', \App\Http\Controllers\Api\V1\Admin\UserListingController::class)
        ->name('api.v1.admin.user_listing');
});
