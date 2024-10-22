<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\RegisterController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');