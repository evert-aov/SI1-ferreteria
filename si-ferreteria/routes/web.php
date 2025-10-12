<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\AuditLog;
use App\Livewire\RoleManager;
use App\Livewire\UserManager;
use Illuminate\Support\Facades\Route;
use \App\Livewire\PermissionManager;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('Administrador')->group(function () {
        Route::get('/users', UserManager::class)->name('users.index');
        Route::get('/roles', RoleManager::class)->name('roles.index');
        Route::get('/audit-logs', AuditLog::class)->name('audit-logs.index');
        Route::get('/permissions', PermissionManager::class)->name('permissions.index');
    });
});


require __DIR__.'/auth.php';
