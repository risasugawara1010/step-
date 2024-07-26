<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    
    if (Auth::check()) {
        
        return redirect()->route('products.index');
        
    } else {
        
        return redirect()->route('login');
        
    }
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'redirectToProducts'])->name('home');


Route::resource('products', ProductController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.detail');

Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');