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



Route::group(['middleware' => 'auth'], function() {

    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::post('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/show/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

});