<?php

namespace Modules\BooksModule\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\BooksModule\Interfaces\Repositories\BookRepositoryInterface;
use Modules\BooksModule\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    public function getById(int $id): Book
    {
        return Book::find($id);
    }

    public function increment_total_read_pages(int $id, int $increment): bool
    {
        $book = $this->getById($id);
        return $book->update([
            'num_of_read_pages' => $book->num_of_read_pages + $increment
        ]);
    }
}
