<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\OpportuniteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes du module CRM
|--------------------------------------------------------------------------
| Necessite le middleware 'role' (CheckRole) enregistre dans
| bootstrap/app.php (Laravel 11+) ou app/Http/Kernel.php (Laravel 10-).
*/

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware(['role:admin,manager,commercial'])->group(function () {
        Route::resource('clients', ClientController::class);
        Route::post('clients/{client}/interactions', [InteractionController::class, 'store'])
            ->name('clients.interactions.store');
        Route::delete('clients/{client}/interactions/{interaction}', [InteractionController::class, 'destroy'])
            ->name('clients.interactions.destroy');

        Route::resource('opportunites', OpportuniteController::class)->except('destroy');
        Route::patch('opportunites/{opportunite}/etape', [OpportuniteController::class, 'changerEtape'])
            ->name('opportunites.changer-etape');
    });

    Route::resource('reclamations', ReclamationController::class);

    Route::middleware(['role:admin,manager'])->group(function () {
        Route::delete('opportunites/{opportunite}', [OpportuniteController::class, 'destroy'])
            ->name('opportunites.destroy');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('utilisateurs', [UserRoleController::class, 'index'])
            ->name('utilisateurs.index');
        Route::patch('utilisateurs/{user}/role', [UserRoleController::class, 'update'])
            ->name('utilisateurs.role.update');
    });
});

require __DIR__.'/auth.php';