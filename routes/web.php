<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\ForwarderController;
use App\Http\Controllers\EmailAliasController;
use App\Http\Controllers\AutoReplyController;
use App\Http\Controllers\EmailLogsController;
use App\Http\Controllers\EmailImportController;
use App\Http\Controllers\VirusScanController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Proteger todas las rutas con middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mailboxes
    Route::prefix('mailboxes')->name('mailboxes.')->group(function () {
        Route::get('/', [MailboxController::class, 'index'])->name('index');
        Route::get('/create', [MailboxController::class, 'create'])->name('create');
        Route::post('/', [MailboxController::class, 'store'])->name('store');
        Route::get('/{mailbox}', [MailboxController::class, 'show'])->name('show');
        Route::get('/{mailbox}/edit', [MailboxController::class, 'edit'])->name('edit');
        Route::put('/{mailbox}', [MailboxController::class, 'update'])->name('update');
        Route::delete('/{mailbox}', [MailboxController::class, 'destroy'])->name('destroy');
        Route::put('/{mailbox}/change-password', [MailboxController::class, 'changePassword'])->name('change-password');
    });

    // Forwarders
    Route::prefix('forwarders')->name('forwarders.')->group(function () {
        Route::get('/', [ForwarderController::class, 'index'])->name('index');
        Route::get('/create', [ForwarderController::class, 'create'])->name('create');
        Route::post('/', [ForwarderController::class, 'store'])->name('store');
        Route::get('/{forwarder}/edit', [ForwarderController::class, 'edit'])->name('edit');
        Route::put('/{forwarder}', [ForwarderController::class, 'update'])->name('update');
        Route::delete('/{forwarder}', [ForwarderController::class, 'destroy'])->name('destroy');
    });

    // Email Alias
    Route::prefix('email-alias')->name('email-alias.')->group(function () {
        Route::get('/', [EmailAliasController::class, 'index'])->name('index');
        Route::get('/create', [EmailAliasController::class, 'create'])->name('create');
        Route::post('/', [EmailAliasController::class, 'store'])->name('store');
        Route::get('/{alias}/edit', [EmailAliasController::class, 'edit'])->name('edit');
        Route::put('/{alias}', [EmailAliasController::class, 'update'])->name('update');
        Route::delete('/{alias}', [EmailAliasController::class, 'destroy'])->name('destroy');
    });

    // Auto Reply
    Route::prefix('auto-reply')->name('auto-reply.')->group(function () {
        Route::get('/', [AutoReplyController::class, 'index'])->name('index');
        Route::get('/create', [AutoReplyController::class, 'create'])->name('create');
        Route::post('/', [AutoReplyController::class, 'store'])->name('store');
        Route::get('/{autoReply}/edit', [AutoReplyController::class, 'edit'])->name('edit');
        Route::put('/{autoReply}', [AutoReplyController::class, 'update'])->name('update');
        Route::delete('/{autoReply}', [AutoReplyController::class, 'destroy'])->name('destroy');
    });

    // Email Logs
    Route::prefix('email-logs')->name('email-logs.')->group(function () {
        Route::get('/', [EmailLogsController::class, 'index'])->name('index');
    });

    // Virus Scan
    Route::prefix('virus-scan')->name('virus-scan.')->group(function () {
        Route::get('/', [VirusScanController::class, 'index'])->name('index');
        Route::post('/{virusScan}/quarantine', [VirusScanController::class, 'quarantine'])->name('quarantine');
        Route::post('/{virusScan}/release', [VirusScanController::class, 'release'])->name('release');
    });

    // Email Import
    Route::prefix('email-import')->name('email-import.')->group(function () {
        Route::get('/', [EmailImportController::class, 'index'])->name('index');
        Route::post('/', [EmailImportController::class, 'import'])->name('import');
    });
});
