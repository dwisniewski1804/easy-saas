<?php

use App\Http\Controllers\Admin\User\CreateUserController;
use App\Http\Controllers\Admin\User\DeleteUserController;
use App\Http\Controllers\Admin\User\UpdateUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Admin routes.
 */
Route::middleware('auth:api')->prefix('admin')->group(function () {
    $userModel = User::class;
    Route::post('user', [CreateUserController::class, 'create'])->middleware("can:create,${userModel}");
    Route::put('user/{user}', [UpdateUserController::class, 'update'])->middleware("can:update,user");
    Route::delete('user/{user}', [DeleteUserController::class, 'delete'])->middleware("can:delete,user");
});
