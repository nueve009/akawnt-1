<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AkawntController;
use App\Http\Controllers\Applicant\DashboardController as ApplicantDashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to home
Route::get('/', function () {
    return redirect('/home');
});

// Pages
Route::get('/home', [AkawntController::class, 'home'])->name('home');
Route::get('/affiliates', [AkawntController::class, 'affiliates'])->name('affiliates');
Route::get('/reports', [AkawntController::class, 'reports'])->name('reports');

// Job Application Submission
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Admin Auth
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('admin.register.submit');

    // Applicant Auth
    Route::get('/login', [AuthController::class, 'showApplicantLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'applicantLogin'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applications/{application}', [AdminDashboardController::class, 'show'])->name('application.show');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('application.accept');
    Route::post('/applications/{application}/decline', [ApplicationController::class, 'decline'])->name('application.decline');
    Route::post('/applications/{application}/review', [ApplicationController::class, 'review'])->name('application.review');
    Route::get('/applications/{application}/resume', [ApplicationController::class, 'downloadResume'])->name('application.download-resume');
});

// Applicant Routes
Route::middleware(['auth', 'applicant'])->prefix('dashboard')->name('applicant.')->group(function () {
    Route::get('/', [ApplicantDashboardController::class, 'index'])->name('dashboard');
});
