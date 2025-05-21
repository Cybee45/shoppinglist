<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ShoppingItemController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, dsb)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Route Setelah Login (Dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [ShoppingItemController::class, 'index'])->name('items.index');

    //Shopping Items
    Route::get('/items/create', [ShoppingItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ShoppingItemController::class, 'store'])->name('items.store');
    Route::delete('/lists/{id}', [ShoppingListController::class, 'destroy'])->name('lists.destroy');
    Route::get('/items/{id}/edit', [ShoppingItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ShoppingItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ShoppingItemController::class, 'destroy'])->name('items.destroy');
    Route::put('/items/{id}/toggle-status', [ShoppingItemController::class, 'toggleStatus'])->name('items.toggleStatus');

    //Tambah item baru ke dalam list yang sudah ada
    Route::get('items/createTambah', [ShoppingItemController::class, 'createTambah'])->name('items.createTambah');
    Route::post('items/storeTambah', [ShoppingItemController::class, 'storeTambahItem'])->name('items.storeTambah');

    //Shopping list
    Route::get('/lists/{id}', [ShoppingListController::class, 'show'])->name('lists.show');
    Route::get('/lists/{id}/edit', [ShoppingListController::class, 'edit'])->name('lists.edit');
    Route::put('/lists/{id}', [ShoppingListController::class, 'update'])->name('lists.update');
    Route::put('/lists/{id}/complete', [ShoppingListController::class, 'complete'])->name('lists.complete');
    Route::put('/lists/{id}/restore', [ShoppingListController::class, 'restore'])->name('lists.restore');


    // Hapus semua dari history
    Route::delete('/items/history/delete-all', [ShoppingItemController::class, 'deleteAllHistory'])->name('items.history.deleteAll');
});
