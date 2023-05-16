<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function(){
    Route::get('/', [MainController::class, 'index'])->name('/');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
 });

Route::middleware(['auth', 'isAdmin'])->group(function(){
    Route::post('saveactivity', [ActivityController::class, 'postactivity']);
    Route::get('getactivity', [ActivityController::class, 'getactivity']);
    Route::put('editactivity/{id}', [ActivityController::class, 'editactivity']);
    Route::get('deleteactivity/{id}', [ActivityController::class, 'deleteactivity']);
    Route::get('users', [UsersController::class, 'index']);
    Route::get('users-activity/{id}', [UsersController::class, 'usersActivity']);
    Route::post('users-activity-post', [UsersController::class, 'usersActivityPost']);
    Route::post('users-activity-edit/{id}', [UsersController::class, 'usersActivityEdit']);
    Route::post('users-activity-edit-global/{id}', [UsersController::class, 'usersActivityEditGlobal']);
    Route::delete('delete-user-activity/{id}', [UsersController::class, 'deleteUserActivity']);
    Route::delete('delete-user-activity-global/{id}', [UsersController::class, 'deleteUserActivityGlobal']);
 });
