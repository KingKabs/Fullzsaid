<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\WalletController;

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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('persons', PersonController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [WalletController::class, 'topUpForm'])->name('wallet.topup');
    Route::post('/wallet/create-invoice', [WalletController::class, 'createInvoice'])->name('wallet.createInvoice');
    Route::post('/wallet/webhook', [WalletController::class, 'handleWebhook'])->name('wallet.webhook');
    Route::get('/wallet/success', [WalletController::class, 'success'])->name('wallet.success');
});

Route::post('/wallet/test/{paymentId}', [WalletController::class, 'testPayment']);

