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
            Route::get('', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::post('', [UserController::class, 'store']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'delete']);
        });
    }
}
