<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;

// Authentication Routes
//Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Public Routes
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Mentor
Route::get('/mentors', [MentorController::class, 'index'])->name('mentors.index');
Route::get('/mentors/{mentor}', [MentorController::class, 'show'])->name('mentors.show');
Route::get('/become-mentor', [MentorController::class, 'create'])->name('mentors.create');
Route::post('/mentors', [MentorController::class, 'store'])->name('mentors.store');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// About Us 
Route::get('/about', function () { 
    return view('about');
})->name('about');

// Guidelines
Route::get('/guidelines', function () {
    return view('guidelines');
})->name('guidelines');


// Protected Routes (Authenticated Users Only)
Route::middleware(['auth'])->group(function () {
    // Sessions
    Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('/sessions/{session}', [SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{session}', [SessionController::class, 'destroy'])->name('sessions.destroy');
    
    // Session Completion
    Route::get('/sessions/{session}/complete', [SessionController::class, 'showComplete'])->name('sessions.show-complete');
    Route::put('/sessions/{session}/complete', [SessionController::class, 'complete'])->name('sessions.complete');

    // Reviews
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    //Profile Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // // Dashboard
    Route::get('/my/progress', [DashboardController::class, 'index'])->name('dashboard');

    // // Goals
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
});

