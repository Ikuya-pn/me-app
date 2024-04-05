<?php
use App\Http\Controllers\Worker\ProfileController;
use App\Http\Controllers\Worker\WorksController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('worker')->name('worker.')->group(function () {
    Route::middleware(['auth:worker'])->group(function() {
        Route::prefix('works')->group(function (){
            Route::get('/', [WorksController::class, 'index'])->name('works.index');
            Route::get('/create/{date}', [WorksController::class, 'create'])->name('works.create');
            Route::post('/store', [WorksController::class, 'store'])->name('works.store');
            Route::put('/update/{id}', [WorksController::class, 'update'])->name('works.update');
        });
        require __DIR__ . '/auth.php';
    });

    require __DIR__ . '/guest.php';
});