<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookPurchaseController;

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);

    Route::post('/{id}/purchase', [
        BookPurchaseController::class,
        'incrementPopularity'
    ])
        ->name('book.incrementPopularity');
});
