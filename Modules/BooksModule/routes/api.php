<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\BooksModule\Controllers\BookController;
use Modules\BooksModule\Controllers\BookReadController;

Route::get('/books/most-read', [BookController::class, 'list_recommended_books'])->name('books.most_read');
Route::post('/books/submit-read', [BookReadController::class, 'store'])->name('books.submit_read');
