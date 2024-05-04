<?php

namespace Modules\BooksModule\Controllers;

use App\Http\Controllers\ApiBaseController;
use Modules\BooksModule\Models\Book;
use Modules\BooksModule\Resources\BookResource;

class BookController extends ApiBaseController
{
    /**
     * List recommended books
     * 
     * List books in descending order according to the number of pages that have been read
     * 
     * 
     *  @response array{success: boolean, books: BookResource[]}
     */
    public function list_recommended_books()
    {
        $books = Book::limit(5)->orderBy('num_of_read_pages', 'desc')->get();

        return $this->success([
            'books' => BookResource::collection($books)
        ]);
    }
}
