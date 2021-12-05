<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConstantsController;

use App\Http\Controllers\Auth\AuthController;

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
/*
Route::middleware('auth:api')->group(function () {
    Route::get('users', [UserController::class, 'index']);
});*/

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/constants', [ConstantsController::class ,'index'])->name('api.constants');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/me', [UserController::class, 'me'])->name('api.me');
         Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResources(array(
            'groups' => GroupController::class,
            'users' => UserController::class,
            'roles' => RoleController::class,
        ));
        Route::get('/users/{user}/groups', function (\App\Models\User $user) {
            $groups = $user->groups;
            foreach ($groups as $group) {
                echo $group->name . '<br>';
            }
        });
        Route::get('/groups/{group}/users', function (\App\Models\Group $group) {
            $users = $group->users;
            foreach ($users as $user) {
                echo $user->name . '<br>';
            }
        });
    });
});
