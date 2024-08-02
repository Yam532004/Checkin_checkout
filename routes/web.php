<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingTimeController;
use App\Http\Controllers\MailController;

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
Route::get('/user/id={id}', [UserController::class, 'get_user'])->middleware(['auth'])->name('user');
Route::put('/edit-user/{id}', [UserController::class, 'edit_user'])->middleware(['auth'])->name('edit_user');
Route::get('/report', [WorkingTimeController::class, 'getMonthReport'])->middleware(['auth'])->name('report');


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
    Route::get('/user', [UserController::class, 'show_user'])->name('user-detail');
    Route::get('/add-user', [UserController::class, 'add_user'])->name('add-user');
    Route::post('/add-user', [UserController::class, 'create_user'])->name('create_user');
    Route::post('/update-user-status', [UserController::class, 'update_user_status'])->name('update_user_status');
    Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('delete_user');
    Route::prefix('working-times')->group(function () {
        Route::get('/', [WorkingTimeController::class, 'index']);
        Route::get('/ontime', [WorkingTimeController::class, 'on_time'])->name('on_time');
        Route::get('/not-yet', [WorkingTimeController::class, 'not_yet_checkout'])->name('not_yet_checkout');
        Route::get('/checkout-early', [WorkingTimeController::class, 'checkout_early'])->name('checkout_early');
        Route::get('/late', [WorkingTimeController::class, 'get_late'])->name('late');
        Route::get('/list-checkin-late', [WorkingTimeController::class, 'list_checkin_late'])->name('list_checkin_late');
        Route::get('/list-checkin-late-in-month', [WorkingTimeController::class, 'list_checkin_late_in_month'])->name('list_checkin_late_in_month');
    });

    // send email 
    Route::post('/send-email', [MailController::class, 'basic_email']);
});

Route::post('/checkin', [WorkingTimeController::class, 'checkIn'])->middleware(['auth'])->name('checkin');
Route::post('/checkout', [WorkingTimeController::class, 'checkOut'])->middleware(['auth'])->name('checkout');
Route::get('/check-status', [WorkingTimeController::class, 'checkStatus'])->middleware(['auth'])->name('check_status');
