<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::prefix('v1/books')->group(function () {
    Route::get('/', [BookController::class, 'apiIndex'])->name('books.apiIndex');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
