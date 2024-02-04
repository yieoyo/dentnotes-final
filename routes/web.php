<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('role');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/queries', [App\Http\Controllers\QueryController::class, 'index'])->name('query');

