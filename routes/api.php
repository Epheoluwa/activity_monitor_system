<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'RegisterUser']);
Route::post('loginUser', [LoginController::class, 'LoginUser']);

Route::middleware(['auth.bearer'])->group(function () {
    Route::get('/activities', [ActivityController::class, 'getActivities']);
});
