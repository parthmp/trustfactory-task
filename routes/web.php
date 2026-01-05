<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return Inertia::render('Home', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');


/* not using Route::resource because this is not the standard REST API */
Route::get('/', [ProductController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function(){
	Route::post('cart/modify', [CartController::class, 'store']);
	Route::get('cart', [CartController::class, 'show']);
	Route::get('cart/checkout', [CartController::class, 'checkout']);
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/settings.php';
