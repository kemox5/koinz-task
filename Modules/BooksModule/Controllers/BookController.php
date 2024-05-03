<?php

namespace Modules\BooksModule\Controllers;

use App\Http\Controllers\ApiBaseController;
use Modules\BooksModule\Models\Book;

class BookController extends ApiBaseController
{
    /**
     * List books in descending order according to the number of pages that have been read
     */
    public function list_most_recommended_books()
    {
        $books = Book::limit(5)->orderBy('num_of_read_pages', 'desc')->get();
        return response()->json([
            'books' => $books
        ]);
    }
}
