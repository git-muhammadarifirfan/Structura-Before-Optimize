<?php

use App\Http\Controllers\web\MvcAuth;
use App\Http\Controllers\web\MvcProfile;
use App\Http\Controllers\web\MvcVerificationMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\web\MvcCartProducth;
use App\Http\Controllers\web\MvcCategory;
use App\Http\Controllers\web\MvcOrder;
use App\Http\Controllers\web\MvcProdutch;
use App\Http\Controllers\web\MvcResetPasswordMail;
use App\Http\Controllers\Web\MvcTripayController;

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


// Public route
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::get('/product', [MvcProdutch::class, 'index'])->name('product');
Route::get('/detail-product/{sku}', [MvcProdutch::class, 'show'])->name('product.detail');
Route::get('/category/{slug}', [MvcCategory::class, 'showByCategory'])->name('byCategory');

Route::get('/store-location', function () {
    return view('store.store-location');
})->name('store-location');

// guest route
Route::middleware('guest')->group(function () {
    Route::get('/register', [MvcAuth::class, 'showRegister'])->name('register');
    Route::post('/register', [MvcAuth::class, 'register']);

    Route::get('/login', [MvcAuth::class, 'showLogin'])->name('login');
    Route::post('/login', [MvcAuth::class, 'login']);

    Route::get('/search', [MvcProdutch::class, 'search'])->name('search');
});

Route::middleware(['auth', 'role:user'])->group(function () {

    // product
    Route::get('/search', [MvcProdutch::class, 'search'])->name('search');

    // Profil pengguna
    Route::get('/profile', [MvcProfile::class, 'show'])->name('profile');
    Route::get('/profile/address', [MvcProfile::class, 'address'])->name('profile.address');
    Route::get('/profile/history', [MvcProfile::class, 'history'])->name('profile.history');
    Route::get('/profile/history-detail/{invoice}', [MvcProfile::class, 'orderDetail'])->name('profile.history.detail');
    Route::post('/profile/address/{id}/default', [MvcProfile::class, 'setDefaultAddress'])->name('profile.setDefault');

    Route::post('/profile/update', [MvcProfile::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/address/add', [MvcProfile::class, 'addAddress'])->name('profile.address.add');
    Route::put('/profile/address/{id}', [MvcProfile::class, 'updateAddress'])->name('profile.address.update');
    Route::delete('/profile/address/{id}', [MvcProfile::class, 'deleteAddress'])->name('profile.address.delete');

    // Keranjang
    Route::get('/cart', [MvcCartProducth::class, 'getUserCart'])->name('cart');
    Route::post('/cart/add', [MvcCartProducth::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [MvcCartProducth::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/delete/{id}', [MvcCartProducth::class, 'deleteCart'])->name('cart.delete');

    // Checkout & Pembayaran
    Route::get('/checkout', [MvcOrder::class, 'checkoutForm'])->name('checkout.form');
    Route::get('/order/cancel/{uuid}', [MvcOrder::class, 'cancelOrder'])->name('order.cancel');

    Route::post('/checkout', [MvcOrder::class, 'processCheckout'])->name('checkout.process');

    Route::get('/order/{uuid}/waiting', [MvcOrder::class, 'waitingPayment'])->name('order.waiting');

    Route::get('/checkout/snap/{uuid}', [MvcOrder::class, 'snapPage'])->name('checkout.snap');

    // Logout
    Route::post('/logout', [MvcAuth::class, 'logout'])->name('logout');
});

// filament
// Route::redirect('/structuradmin/login', '/login');


// back end route for email
Route::get('/email/verify/{id}/{hash}', [MvcVerificationMail::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/resend', [MvcVerificationMail::class, 'resendVerificationEmail'])->name('verification.resend');

Route::get('/forgot-password', [MvcResetPasswordMail::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [MvcResetPasswordMail::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password', [MvcResetPasswordMail::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [MvcResetPasswordMail::class, 'resetPassword'])->name('password.update');

Route::get('/reset-password/expired', function () {
    return view('auth.reset-expired');
})->name('password.link.expired');


// tripay
// Callback
Route::post('/callback/tripay', [MvcTripayController::class, 'handleCallback'])->name('tripay.callback');
