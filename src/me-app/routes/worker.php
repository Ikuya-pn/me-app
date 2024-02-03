<?php
use App\Http\Controllers\Worker\ProfileController;
use App\Http\Controllers\Worker\WorkerController;
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

        Route::get('/', [WorkerController::class, 'index'])->name('worker.index');
    });

    require __DIR__ . '/auth.php';
});