<?php

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

Route::get('/', function () {
    return view('layouts.admin');
});

Route::prefix('admins')->group(function (){
    Route::get('/',[\App\Http\Controllers\backend\HomeController::class,'index'])->name('admins.index');
    Route::get('login',[\App\Http\Controllers\backend\HomeController::class,'index'])->name('admins.index');

    Route::prefix('/authors')->group(function (){
        Route::get('/create',[\App\Http\Controllers\backend\AuthorController::class,'create'])->name('authors.create');
        Route::get('/edit/{id}',[\App\Http\Controllers\backend\AuthorController::class,'edit'])->name('authors.edit');
        Route::post('/delete',[\App\Http\Controllers\backend\AuthorController::class,'delete'])->name('authors.delete');
        Route::post('/store',[\App\Http\Controllers\backend\AuthorController::class,'store'])->name('authors.store');
        Route::post('/update',[\App\Http\Controllers\backend\AuthorController::class,'update'])->name('authors.update');
        Route::post('/',[\App\Http\Controllers\backend\AuthorController::class,'search'])->name('authors.search');
        Route::get('/',[\App\Http\Controllers\backend\AuthorController::class,'index'])->name('authors.index');
    });

    Route::prefix('/categories')->group(function (){
        Route::get('/create',[\App\Http\Controllers\backend\CategoryController::class,'create'])->name('categories.create');
/*        Route::get('/edit/{id}',[\App\Http\Controllers\backend\CategoryController::class,'edit'])->name('categories.edit');*/
        Route::get('/delete/{id}',[\App\Http\Controllers\backend\CategoryController::class,'delete'])->name('categories.delete');
        Route::post('/store',[\App\Http\Controllers\backend\CategoryController::class,'store'])->name('categories.store');
        Route::post('/update',[\App\Http\Controllers\backend\CategoryController::class,'update'])->name('categories.update');
        Route::post('/',[\App\Http\Controllers\backend\CategoryController::class,'search'])->name('categories.search');
        Route::get('/',[\App\Http\Controllers\backend\CategoryController::class,'index'])->name('categories.index');
    });

    Route::prefix('/books')->group(function (){
        Route::get('/create',[\App\Http\Controllers\backend\BookController::class,'create'])->name('books.create');
        Route::get('/edit/{id}',[\App\Http\Controllers\backend\BookController::class,'edit'])->name('books.edit');
        Route::post('/delete',[\App\Http\Controllers\backend\BookController::class,'delete'])->name('books.delete');
        Route::post('/store',[\App\Http\Controllers\backend\BookController::class,'store'])->name('books.store');
        Route::post('/update',[\App\Http\Controllers\backend\BookController::class,'update'])->name('books.update');
        Route::post('/',[\App\Http\Controllers\backend\BookController::class,'search'])->name('books.search');
        Route::get('/',[\App\Http\Controllers\backend\BookController::class,'index'])->name('books.index');
    });
});
