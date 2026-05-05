<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Mail;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/categories', function () {
    return view('frontend.pages.categories');
});
Route::get('/item', function () {
    return view('frontend.pages.item');
});
Route::get('/cart', function () {
    return view('frontend.pages.cart');
});
Route::get('/checkout', function () {
    return view('frontend.pages.checkout');
});
Route::get('/about-us', function () {
    return view('frontend.pages.about-us');
});
Route::get('/contact-us', function () {
    return view('frontend.pages.contact-us');
});

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', function () {
    return view('frontend.pages.cart.index');
})->name('cart');

Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');

Route::get('/category/{category:slug}/products', [ProductController::class, 'categoryProducts'])
    ->name('category.products');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

//Payment Routes

Route::get('/payment/card/{order}', [PaymentController::class, 'card'])->name('payment.card');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel/{orderId}', [PaymentController::class, 'cancel'])
    ->name('payment.cancel');
