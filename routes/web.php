<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantSubmissionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{slug}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::post('/restaurants/{slug}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/restaurants/{slug}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/restaurants/{slug}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/restaurants/{slug}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [UserController::class, 'bookings'])->name('user.bookings');
    Route::get('/my-reviews', [UserController::class, 'reviews'])->name('user.reviews');
    Route::get('/my-restaurants', [RestaurantSubmissionController::class, 'index'])->name('user.restaurants');
    Route::get('/submit-restaurant', [RestaurantSubmissionController::class, 'create'])->name('restaurants.submit');
    Route::post('/submit-restaurant', [RestaurantSubmissionController::class, 'store']);
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('restaurants', AdminRestaurantController::class);

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}', [AdminReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});
