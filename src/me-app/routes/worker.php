<?php
use App\Http\Controllers\Worker\ProfileController;
use App\Http\Controllers\Worker\WorksController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('worker')->name('worker.')->group(function () {
    Route::middleware(['auth:worker'])->group(function() {
        Route::get('/dashboard', function () {
            return Inertia::render('Worker/Dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('works')->group(function (){
            Route::get('/index', [WorksController::class, 'index'])->name('works.index');
            Route::get('/create/{date}', [WorksController::class, 'create'])->name('works.create');
            Route::post('/store', [WorksController::class, 'store'])->name('works.store');
            Route::put('/update/{id}', [WorksController::class, 'update'])->name('works.update');
        });
       
    });

    require __DIR__ . '/auth.php';
});