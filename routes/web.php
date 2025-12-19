<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CoinPaymentsController;

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
    Route::post('/wallet/create-payment', [WalletController::class, 'createPayment'])->name('wallet.createPayment');
    Route::post('/wallet/webhook', [WalletController::class, 'handleWebhook'])->name('wallet.webhook');
    Route::get('/wallet/success', [WalletController::class, 'success'])->name('wallet.success');
    Route::get('/wallet/cancel', [WalletController::class, 'cancel'])->name('wallet.cancel');
    // Check payment status (AJAX)
    Route::get('/wallet/payment-status/{payment}', [WalletController::class, 'checkPaymentStatus'])->name('wallet.payment.status');
});

Route::get('/nowpayments/status/{paymentId}', [WalletController::class, 'getPaymentStatus'])
        ->name('nowpayments.status');

Route::middleware(['auth'])->group(function () {
    Route::get('/payments', [App\Http\Controllers\PaymentsController::class, 'index'])
            ->name('payments.index');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/wallet/coinpayments/create', [CoinPaymentsController::class, 'createPayment'])
            ->name('coinpayments.create');
    Route::post('/wallet/coinpayments/create-invoice', [CoinPaymentsController::class, 'createInvoice'])
            ->name('coinpayments.createInvoice');
});

Route::post('/wallet/coinpayments/ipn', [CoinPaymentsController::class, 'ipn'])
        ->name('coinpayments.ipn');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
});

Route::post('/wallet/test/{paymentId}', [WalletController::class, 'testPayment']);

