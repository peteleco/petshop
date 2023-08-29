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

// Routes that must be authenticated
Route::group([
    'middleware' => 'auth:api', // 'auth' => \App\Http\Middleware\Authenticate::class,
], function (): void {
});
