<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Technician;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/how-it-works', fn () => view('how-it-works'))->name('how-it-works');
Route::get('/technicians', [User\TechnicianController::class, 'index'])->name('technicians.index');
Route::get('/technicians/{technician}', [User\TechnicianController::class, 'show'])->name('technicians.show');

// Diagnosis tools — free to use without an account
Route::get('/diagnosis', [User\ConsultationController::class, 'create'])->name('diagnosis.create');
Route::post('/diagnosis', [User\ConsultationController::class, 'storeStep1'])->middleware('throttle:diagnosis')->name('diagnosis.store');
Route::get('/diagnosis/{consultation:access_token}', [User\ConsultationController::class, 'result'])->name('diagnosis.result');
Route::get('/diagnosis/{consultation:access_token}/questions', [User\ConsultationController::class, 'questions'])->name('diagnosis.questions');
Route::post('/diagnosis/{consultation:access_token}/answers', [User\ConsultationController::class, 'processAnswers'])->name('diagnosis.answers');
Route::get('/repair-guides/{repairGuide}', [User\RepairGuideController::class, 'show'])->name('repair-guides.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register: chooser + separate flows
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/user', [AuthController::class, 'showRegisterUser'])->name('register.user');
    Route::post('/register/user', [AuthController::class, 'registerUser'])->name('register.user.store');
    Route::get('/register/technician', [AuthController::class, 'showRegisterTechnician'])->name('register.technician');
    Route::post('/register/technician', [AuthController::class, 'registerTechnician'])->name('register.technician.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [User\ProfileController::class, 'changePassword'])->name('profile.password');

    // Saved diagnoses (the diagnosis tool itself is public)
    Route::get('/diagnosis', [User\ConsultationController::class, 'index'])->name('diagnosis.index');

    // Bookings
    Route::get('/bookings', [User\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [User\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [User\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [User\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [User\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Messages
    Route::get('/messages', [User\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{booking}', [User\MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{booking}/list', [User\MessageController::class, 'getMessages'])->name('messages.list');

    // Reviews
    Route::post('/reviews/{booking}', [User\ReviewController::class, 'store'])->name('reviews.store');

    // History
    Route::get('/history', [User\ConsultationController::class, 'history'])->name('history');
});

// Technician routes
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function () {
    Route::get('/dashboard', [Technician\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [Technician\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Technician\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/requests', [Technician\BookingController::class, 'requests'])->name('requests');
    Route::get('/bookings', [Technician\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [Technician\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/accept', [Technician\BookingController::class, 'accept'])->name('bookings.accept');
    Route::patch('/bookings/{booking}/reject', [Technician\BookingController::class, 'reject'])->name('bookings.reject');
    Route::patch('/bookings/{booking}/start', [Technician\BookingController::class, 'startWork'])->name('bookings.start');
    Route::patch('/bookings/{booking}/complete', [Technician\BookingController::class, 'complete'])->name('bookings.complete');

    Route::get('/bookings/{booking}/report/create', [Technician\RepairReportController::class, 'create'])->name('repair-reports.create');
    Route::post('/bookings/{booking}/report', [Technician\RepairReportController::class, 'store'])->name('repair-reports.store');

    Route::get('/messages', [Technician\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{booking}', [Technician\MessageController::class, 'send'])->name('messages.send');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/technicians', [Admin\TechnicianController::class, 'index'])->name('technicians.index');
    Route::get('/technicians/{technician}', [Admin\TechnicianController::class, 'show'])->name('technicians.show');
    Route::patch('/technicians/{technician}/verify', [Admin\TechnicianController::class, 'verify'])->name('technicians.verify');
    Route::patch('/technicians/{technician}/reject', [Admin\TechnicianController::class, 'reject'])->name('technicians.reject');
    Route::patch('/technicians/{technician}/suspend', [Admin\TechnicianController::class, 'suspend'])->name('technicians.suspend');

    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('devices', Admin\DeviceController::class);
    Route::resource('symptoms', Admin\SymptomController::class);
    Route::resource('diagnoses', Admin\DiagnosisController::class);
    Route::resource('solutions', Admin\SolutionController::class);

    Route::get('/rules/symptoms/{device}', [Admin\RuleController::class, 'getSymptoms'])->name('rules.symptoms');
    Route::get('/rules/diagnoses/{device}', [Admin\RuleController::class, 'getDiagnoses'])->name('rules.diagnoses');
    Route::resource('rules', Admin\RuleController::class);

    Route::resource('repair-guides', Admin\RepairGuideController::class);

    Route::get('/consultations', [Admin\ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/{consultation}', [Admin\ConsultationController::class, 'show'])->name('consultations.show');
});

// Redirect based on role after login
Route::middleware('auth')->get('/redirect', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'technician' => redirect()->route('technician.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->name('redirect');
