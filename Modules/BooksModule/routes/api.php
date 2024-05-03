<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\BooksModule\Controllers\BookController;
use Modules\BooksModule\Controllers\BookReadController;

Route::get('/books/top', [BookController::class, 'list_recommended_books'])->name('recommended_books.list');
Route::post('/book_read/new', [BookReadController::class, 'store'])->name('book_read.store');

Route::post('/test_sms', function (Request $request) {
    Log::debug(json_encode($request->all()));
});
