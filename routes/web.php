<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Auth middleware for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('role');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/queries', [App\Http\Controllers\QueryController::class, 'index'])->name('query');
    Route::resource('user', App\Http\Controllers\UserController::class, [
        'names' => [
            'index'   => 'user.index',
            'create'  => 'user.create',
            'store'   => 'user.store',
            'show'    => 'user.show',
            'edit'    => 'user.edit',
            'update'  => 'user.update',
            'destroy' => 'user.destroy',
        ],
    ]);
});

