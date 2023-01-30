<?php

namespace MoneyTransaction\Presentation\Http\Routes;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use MoneyTransaction\Presentation\Http\Controllers\User\UserController;

class Router extends RouteServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Route::middleware(['web'])->prefix('users')->name('users.')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('index');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::post('', [UserController::class, 'store'])->name('store');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
        });
    }
}
