<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
Auth::routes(['verify' => true]);
Route::get('/admins/login', [\App\Http\Controllers\backend\LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/admins/login', [\App\Http\Controllers\backend\LoginController::class, 'login'])->name('login');
Route::get('/admins/logout', [\App\Http\Controllers\backend\LoginController::class, 'logout'])->name('logout');

Route::middleware('admin')->prefix('admins')->group(function () {
    Route::get('/', [\App\Http\Controllers\backend\HomeController::class, 'index'])->name('admins.index');

    Route::prefix('/authors')->group(function () {
        Route::get('/create', [\App\Http\Controllers\backend\AuthorController::class, 'create'])->name('authors.create');
        Route::get('/edit/{id}', [\App\Http\Controllers\backend\AuthorController::class, 'edit'])->name('authors.edit');
        Route::post('/delete', [\App\Http\Controllers\backend\AuthorController::class, 'delete'])->name('authors.delete');
        Route::post('/softDelete', [\App\Http\Controllers\backend\AuthorController::class, 'softDelete'])->name('authors.soft-delete');
        Route::post('/store', [\App\Http\Controllers\backend\AuthorController::class, 'store'])->name('authors.store');
        Route::post('/update', [\App\Http\Controllers\backend\AuthorController::class, 'update'])->name('authors.update');
        Route::post('/', [\App\Http\Controllers\backend\AuthorController::class, 'search'])->name('authors.search');
        Route::get('/', [\App\Http\Controllers\backend\AuthorController::class, 'index'])->name('authors.index');
        Route::get('/trashed', [\App\Http\Controllers\backend\AuthorController::class, 'showTrashed'])->name('authors.trashed');
        Route::get('/restore/{id}', [\App\Http\Controllers\backend\AuthorController::class, 'restore'])->name('authors.restore');
    });

    Route::prefix('/categories')->group(function () {
        Route::get('/create', [\App\Http\Controllers\backend\CategoryController::class, 'create'])->name('categories.create');
        /*        Route::get('/edit/{id}',[\App\Http\Controllers\backend\CategoryController::class,'edit'])->name('categories.edit');*/
        Route::get('/delete/{id}', [\App\Http\Controllers\backend\CategoryController::class, 'delete'])->name('categories.delete');
        Route::post('/store', [\App\Http\Controllers\backend\CategoryController::class, 'store'])->name('categories.store');
        Route::post('/update', [\App\Http\Controllers\backend\CategoryController::class, 'update'])->name('categories.update');
        Route::post('/', [\App\Http\Controllers\backend\CategoryController::class, 'search'])->name('categories.search');
        Route::get('/', [\App\Http\Controllers\backend\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/trashed', [\App\Http\Controllers\backend\CategoryController::class, 'showTrashed'])->name('categories.trashed');
        Route::get('/restore/{id}', [\App\Http\Controllers\backend\CategoryController::class, 'restore'])->name('categories.restore');
    });

    Route::prefix('/books')->group(function () {
        Route::get('/create', [\App\Http\Controllers\backend\BookController::class, 'create'])->name('books.create');
        Route::get('/edit/{id}', [\App\Http\Controllers\backend\BookController::class, 'edit'])->name('books.edit');
        Route::get('/delete', [\App\Http\Controllers\backend\BookController::class, 'showDeleteForm'])->name('books.showDeleteForm');
        Route::post('/softDelete', [\App\Http\Controllers\backend\BookController::class, 'softDelete'])->name('books.softDelete');
        Route::get('/restore/{id}', [\App\Http\Controllers\backend\BookController::class, 'restore'])->name('books.restore');
        Route::post('/delete', [\App\Http\Controllers\backend\BookController::class, 'delete'])->name('books.delete');
        Route::post('/store', [\App\Http\Controllers\backend\BookController::class, 'store'])->name('books.store');
        Route::post('/update', [\App\Http\Controllers\backend\BookController::class, 'update'])->name('books.update');
        Route::get('/search-trash', [\App\Http\Controllers\backend\BookController::class, 'searchInTrash'])->name('books.search-trash');
        Route::get('/search', [\App\Http\Controllers\backend\BookController::class, 'search'])->name('books.search');
        Route::get('/', [\App\Http\Controllers\backend\BookController::class, 'index'])->name('books.index');
        Route::get('/trashed', [\App\Http\Controllers\backend\BookController::class, 'showTrashed'])->name('books.trashed');
    });
    Route::prefix('/orders')->group(function () {
        Route::get('/', [\App\Http\Controllers\backend\OrderController::class, 'showOrders'])->name('orders.index');
        Route::get('/by-book/{id}', [\App\Http\Controllers\backend\OrderController::class, 'showOrdersByBook'])->name('orders.byBook');
        Route::get('/trashed', [\App\Http\Controllers\backend\OrderController::class, 'showTrashedOrders'])->name('orders.trashed');
        Route::get('/restore/{id}', [\App\Http\Controllers\backend\OrderController::class, 'restoreOrder'])->name('orders.restore');
        Route::get('/detail/{id}', [\App\Http\Controllers\backend\OrderController::class, 'showOrderDetail'])->name('order.detail');
        Route::get('/cancel/{id}', [\App\Http\Controllers\backend\OrderController::class, 'cancelOrder'])->name('order.cancel');
    });
});

Route::prefix('/book-store')->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/list', [\App\Http\Controllers\HomeController::class, 'listBook'])->name('books.list');
    Route::get('/book-detail/{id}', [\App\Http\Controllers\HomeController::class, 'viewBookDetail'])->name('book.detail');
    Route::get('/by-category/{id}', [\App\Http\Controllers\HomeController::class, 'viewByCategory'])->name('books.by-category');

    Route::get('/add-to-cart', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');
    Route::get('/removeItem', [\App\Http\Controllers\CartController::class, 'removeItem'])->name('removeItem');
    Route::get('/update-cart', [\App\Http\Controllers\CartController::class, 'updateCart'])->name('updateCart');
    Route::get('/update-shipCost', [\App\Http\Controllers\CartController::class, 'updateShipCost'])->name('updateShipCost');
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'showCart'])->name('showCart');
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'showCheckout'])->name('showCheckout');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('checkout');
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'showLogin'])->name('showFrontendLogin');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('frontendLogin');
    Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'showRegister'])->name('showFrontendRegister');
    Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'register'])->name('register');
    Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('frontendLogout');
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');
});
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
