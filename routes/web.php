<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    return view('welcome');
});

Route::get('/pegawai',[EmployeeController::class, 'index'])->name('pegawai')->middleware('auth','verified');

Route::get('/tambahpegawai',[EmployeeController::class, 'tambahpegawai'])->name('tambahpegawai');
Route::post('/insertdata',[EmployeeController::class, 'insertdata'])->name('insertdata');

Route::get('/tampilkandata/{id}',[EmployeeController::class, 'tampilkandata'])->name('tampilkandata');
Route::post('/updatedata/{id}',[EmployeeController::class, 'updatedata'])->name('updatedata');

Route::get('/delete/{id}',[EmployeeController::class, 'delete'])->name('delete');

Route::get('/exportpdf',[EmployeeController::class, 'exportpdf'])->name('exportpdf');

Route::get('/exportexcel',[EmployeeController::class, 'exportexcel'])->name('exportexcel');

Route::post('/importexcel',[EmployeeController::class, 'importexcel'])->name('importexcel');

Route::get('/login',[LoginController::class, 'login'])->name('login');
Route::post('/loginuser',[LoginController::class, 'loginuser'])->name('loginuser');

Route::get('/register',[LoginController::class, 'register'])->name('register');
Route::post('/registeruser',[LoginController::class, 'registeruser'])->name('registeruser');

Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', [VerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('auth','signed')->name('verification.verify');

Route::get('/email/verify/resend', [VerificationController::class, 'send'])->middleware(['auth','throttle:6,1'])->name('verification.send');
Route::post('/email/verify/resend', [VerificationController::class, 'send'])->middleware(['auth','throttle:6,1'])->name('verification.send');

Route::middleware(['auth','auth.session','verified'])->group(function () {
    Route::get('/dashboard', function () {
    });
});