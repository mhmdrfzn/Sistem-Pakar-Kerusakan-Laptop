<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DiagnosaController;
use Illuminate\Support\Facades\Route;

// =========================================
// PUBLIC ROUTES
// =========================================

Route::get('/', [DiagnosaController::class, 'index'])->name('home');
Route::get('/diagnosa', [DiagnosaController::class, 'form'])->name('diagnosa.form');
Route::post('/diagnosa/proses', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
Route::get('/riwayat', [DiagnosaController::class, 'riwayat'])->name('diagnosa.riwayat');
Route::get('/riwayat/{id}', [DiagnosaController::class, 'detail'])->name('diagnosa.detail');
Route::get('/api/gejala', [DiagnosaController::class, 'apiGejala'])->name('api.gejala');

// =========================================
// CHATBOT ROUTES
// =========================================
Route::post('/chatbot/reply', [ChatbotController::class, 'reply'])->name('chatbot.reply');
Route::get('/chatbot/admin-contact', [ChatbotController::class, 'adminContact'])->name('chatbot.admin');


// =========================================
// ADMIN AUTH ROUTES (GUEST ONLY)
// =========================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Login & Logout (tidak butuh auth)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // =========================================
    // ADMIN PROTECTED ROUTES
    // =========================================
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Kerusakan
        Route::get('kerusakan', [KerusakanController::class, 'index'])->name('kerusakan.index');
        Route::get('kerusakan/create', [KerusakanController::class, 'create'])->name('kerusakan.create');
        Route::post('kerusakan', [KerusakanController::class, 'store'])->name('kerusakan.store');
        Route::get('kerusakan/{kerusakan}', [KerusakanController::class, 'show'])->name('kerusakan.show');
        Route::get('kerusakan/{kerusakan}/edit', [KerusakanController::class, 'edit'])->name('kerusakan.edit');
        Route::put('kerusakan/{kerusakan}', [KerusakanController::class, 'update'])->name('kerusakan.update');
        Route::delete('kerusakan/{kerusakan}', [KerusakanController::class, 'destroy'])->name('kerusakan.destroy');

        // Manage Rules per Kerusakan
        Route::get('kerusakan/{kerusakan}/rules', [RuleController::class, 'manageByKerusakan'])->name('kerusakan.rules');
        Route::post('kerusakan/{kerusakan}/rules', [RuleController::class, 'saveByKerusakan'])->name('kerusakan.rules.save');

        // CRUD Gejala
        Route::get('gejala', [GejalaController::class, 'index'])->name('gejala.index');
        Route::get('gejala/create', [GejalaController::class, 'create'])->name('gejala.create');
        Route::post('gejala', [GejalaController::class, 'store'])->name('gejala.store');
        Route::get('gejala/{gejala}/edit', [GejalaController::class, 'edit'])->name('gejala.edit');
        Route::put('gejala/{gejala}', [GejalaController::class, 'update'])->name('gejala.update');
        Route::delete('gejala/{gejala}', [GejalaController::class, 'destroy'])->name('gejala.destroy');

        // CRUD Rules CF
        Route::get('rules', [RuleController::class, 'index'])->name('rules.index');
        Route::get('rules/create', [RuleController::class, 'create'])->name('rules.create');
        Route::post('rules', [RuleController::class, 'store'])->name('rules.store');
        Route::get('rules/{rule}/edit', [RuleController::class, 'edit'])->name('rules.edit');
        Route::put('rules/{rule}', [RuleController::class, 'update'])->name('rules.update');
        Route::delete('rules/{rule}', [RuleController::class, 'destroy'])->name('rules.destroy');

    });
});
