<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
})->middleware('checkLogin');

Route::get('/homepage', function () {
    return view('homepage');
})->middleware(['auth'])->name('homepage');

require __DIR__ . '/auth.php';

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('adminLayout'); // Named route

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/employees', function () {
        return view('users');
    })->name('employees');
    Route::get('/users', [UserController::class, 'get_all_users'])->name('users');
    Route::get('/user/id={id}',[UserController::class, 'get_user'])->name('user');
    Route::get('/add-user', [UserController::class, 'add_user'])->name('add-user');
    Route::post('/add-user', [UserController::class, 'create_user'])->name('create_user');
    Route::put('/edit-user/{id}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('delete_user');
});
