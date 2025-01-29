<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebsiteUserController;
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
Route::get('migrate', function () {
    \Artisan::call('migrate');
    dd("Migration done");
});


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [WebsiteUserController::class,'index'])->name('users.index');
Route::get('/user/{id}', [WebsiteUserController::class, 'show'])->name('user.show');

Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');

Route::get('/email', [EmailController::class, 'create'])->name('email.create');

Route::post('email/send', [EmailController::class, 'sendEmail'])->name('send.email');



Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');

