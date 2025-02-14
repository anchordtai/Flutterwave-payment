<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('payment.form');
}); 

// Show the payment form
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

// Initiate payment (CORRECTED)
Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');

// Payment callback URL after user completes payment
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

// Optionally, you can create routes for success and failure views
Route::get('/payment/success', function () {
    return view('payment.success'); // Create a success view
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed'); // Create a failure view
})->name('payment.failed');