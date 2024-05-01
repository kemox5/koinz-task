<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/books/top', [BookController::class, 'list_most_recommended_books'] );
Route::post('/book_read/new', [BookReadController::class, 'store'] );
