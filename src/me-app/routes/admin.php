<?php
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\WorksController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/show/{worker}', [AdminController::class, 'show'])->name('show');
        Route::get('/store/{worker}', [AdminController::class, 'store'])->name('store');

        Route::prefix('customer')->group(function(){
            Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
            Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
            Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');
        });

        Route::prefix('worker')->group(function(){
            Route::get('/', [WorkerController::class, 'index'])->name('worker.index');
            Route::get('/create', [WorkerController::class, 'create'])->name('worker.create');
            Route::post('/store', [WorkerController::class, 'store'])->name('worker.store');
            Route::get('/show/{id}', [WorkerController::class, 'show'])->name('worker.show');
            Route::get('/edit/{id}', [WorkerController::class, 'edit'])->name('worker.edit');
            Route::put('/update/{id}', [WorkerController::class, 'update'])->name('worker.update');
            Route::delete('/delete/{id}', [WorkerController::class, 'destroy'])->name('worker.delete');
            Route::get('/salary-show/{id}', [WorkerController::class, 'salary_show'])->name('worker.salary-show');
        });

        Route::prefix('works')->group(function(){
            Route::get('/', [WorksController::class, 'index'])->name('works.index');
            Route::get('/edit/{id}', [WorksController::class, 'edit'])->name('works.edit');
            Route::put('/update/{id}', [WorksController::class, 'update'])->name('works.udpate');
            Route::delete('/delete/{id}', [WorksController::class, 'destroy'])->name('works.delete');
        });
        require __DIR__ . '/auth.php';
    });
    require __DIR__ . '/guest.php';
});