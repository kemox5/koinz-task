<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRead;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * List books in descending order according to the number of pages that have been read
     */
    public function list_most_recommended_books(Request $request)
    {
        $books = Book::limit(5)->orderBy('num_of_read_pages', 'desc')->get();
        return response()->json([
            'books' => $books
        ]);
    }
}
