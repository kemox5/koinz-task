<?php

use Illuminate\Support\Facades\Route;
use Modules\BooksModule\Controllers\BookController;
use Modules\BooksModule\Controllers\BookReadController;

Route::get('/books/top', [BookController::class, 'list_recommended_books'])->name('recommended_books.list');
Route::post('/book_read/new', [BookReadController::class, 'store'])->name('book_read.store');
