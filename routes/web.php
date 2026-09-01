<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryTargetController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ReportController;

// Redirect root to dashboard or login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Change Password
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management CRUD
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/direct-login', [UserController::class, 'directLogin'])->name('users.direct-login');

    // Category Target CRUD
    Route::resource('category-targets', CategoryTargetController::class)->except(['show']);
    Route::post('/category-targets/{category_target}/toggle-status', [CategoryTargetController::class, 'toggleStatus'])->name('category-targets.toggle-status');

    // Lead Source CRUD
    Route::resource('lead-sources', LeadSourceController::class)->except(['show']);
    Route::post('/lead-sources/{lead_source}/toggle-status', [LeadSourceController::class, 'toggleStatus'])->name('lead-sources.toggle-status');

    // Leads CRUD & Follow-ups
    Route::resource('leads', LeadController::class);
    Route::post('/leads/{lead}/followup', [LeadController::class, 'storeFollowup'])->name('leads.followup');

    // Admin Reports Generator & CSV Export
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.export-csv');
});
