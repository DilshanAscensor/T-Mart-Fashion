<?php

use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


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

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::post('/wishlist/add/{product}', [WishlistController::class, 'store'])->name('wishlist.add');

Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
Route::get('/category/{category:slug}/products', [ProductController::class, 'categoryProducts'])
    ->name('category.products');
    
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);


