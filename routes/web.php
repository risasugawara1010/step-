<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
})->name('root');

Route::get('/home', [ProductController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/show/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});