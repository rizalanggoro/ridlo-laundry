<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Halaman Landing Page
Route::get('/', function () {
    return view('home'); 
})->name('home');

// Halaman About Us
Route::get('/about', function () {
    return view('about'); 
})->name('about');

// Halaman Services
Route::get('/services', function () {
    return view('service'); 
})->name('services');

// Halaman Pricing
Route::get('/pricing', function () {
    return view('pricing'); 
})->name('pricing');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Include auth.php routes
require __DIR__.'/auth.php';
