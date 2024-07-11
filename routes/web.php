<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\BorrowedItemController;
use App\Http\Controllers\DamagedItemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');
    Route::get('/items', [ItemsController::class, 'index'])->name('items.index');
    Route::get('/items/sort', [ItemsController::class, 'sort']);
    Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
    Route::put('/items/{item}', [ItemsController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemsController::class, 'destroy'])->name('items.destroy');
    Route::get('/borrowed-items', [BorrowedItemController::class, 'index'])->name('borrowed-items.index');
    Route::post('/borrowed-items', [BorrowedItemController::class, 'store'])->name('borrowed-items.store');
    Route::get('total-borrowed-quantity-per-item', [BorrowedItemController::class, 'totalBorrowedQuantityPerItem'])
    ->name('borrowed-items.totalBorrowedQuantityPerItem');
    Route::post('/borrowed-items/return', [BorrowedItemController::class, 'returnItem'])->name('borrowed-items.return');
    Route::get('total-overdue-quantities-per-item', [BorrowedItemController::class, 'totalOverdueQuantitiesPerItem'])
    ->name('borrowed-items.totalOverdueQuantitiesPerItem');
    Route::get('/damaged-items', [DamagedItemController::class, 'index'])->name('damaged-items.index');
    Route::post('damaged-items', [BorrowedItemController::class, 'markAsDamaged'])->name('damaged-items.post');
    Route::post('/damaged-items/repair', [DamagedItemController::class, 'repairItem'])->name('damaged-items.repair');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
