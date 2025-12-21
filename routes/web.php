<?php

use App\Http\Controllers\UserPortal\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\CategoryPageController;
use App\Http\Controllers\CheckoutPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserPortal\Dashboard;
use App\Http\Controllers\UserPortal\PasswordController;

Route::get('/', [HomePageController::class, 'homePage'])->name('home');
Route::get('/about', [HomePageController::class, 'aboutPage'])->name('about');
Route::get('/contact', [HomePageController::class, 'contactPage'])->name('contact');
Route::get('/privacy-policy', [HomePageController::class, 'privacyPolicyPage'])->name('privacy-policy');
Route::get('/terms-conditions', [HomePageController::class, 'termsConditionsPage'])->name('terms-conditions');
// Route::get('/return-policy', [HomePageController::class, 'returnPolicyPage'])->name('return-policy');
// Route::get('/shipping-policy', [HomePageController::class, 'shippingPolicyPage'])->name('shipping-policy');
// Route::get('/refund-policy', [HomePageController::class, 'refundPolicyPage'])->name('refund-policy');
// Route::get('/faq', [HomePageController::class, 'faqPage'])->name('faq');


Route::get('/categories', [CategoryPageController::class, 'categoryPage'])->name('categories');
Route::get('/category/{category:slug}', [CategoryPageController::class, 'categoryDetails'])->name('category-details');

Route::get('/item/{id}', [HomePageController::class, 'itemDetails'])->name('item-details');
Route::get('/order-placed', function () {
    return view('web.confirm');
})->name('order-placed');
// Route::get('/item/{id}', [HomePageController::class, 'item'])->name('item');
// Route::get('/cart', [HomePageController::class, 'cart'])->name('cart');
// Route::get('/checkout', [HomePageController::class, 'checkout'])->name('checkout');
// Route::get('/order', [HomePageController::class, 'order'])->name('order');
// Route::get('/order/{id}', [HomePageController::class, 'orderDetail'])->name('orderDetail');




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::get('/checkout', [CheckoutPageController::class, 'checkoutPage'])->name('checkout');
    Route::post('/checkout/process', [OrderController::class, 'checkout'])->name('checkout.process');

    Route::get('/support', [Dashboard::class, 'support'])->name('support');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/privacy', [ProfileController::class, 'privacy'])->name('user.privacy');
    Route::get('/passwords', [PasswordController::class, 'index'])->name('user.password');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/avatar/update', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/profile/two-factor/update', [ProfileController::class, 'updateTwoFactor'])->name('profile.two-factor.update');
    // route("profile.two-factor.update")
});

// Route::apiResource('home', App\Http\Controllers\API\HomeController::class);

require __DIR__.'/auth.php';

Route::get('/404', function () {
    return view('web.404');
})->name('404');

