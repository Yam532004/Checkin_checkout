<?php 
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/', function () {
        return view('dashboard');
    })->name('admin.dashboard'); // Named route

    Route::get('/view_user', function () {
        return view('admin.view_user');
    })->name('admin.view_user'); // Named route
});
