<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// api.php
Route::post('/shorten', [ShortUrlController::class, 'store']);

// web.php
Route::get('/{keyword}', [ShortUrlController::class, 'redirect']);

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
