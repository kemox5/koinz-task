<?php

namespace Modules\BooksModule\Dtos;

use App\Dtos\Dto;

class BookReadDto extends Dto
{

    public function __construct(public readonly int $book_id, public readonly int $user_id, public readonly int $start_page, public readonly int $end_page)
    {
    }

    public function get_total_pages(): int
    {
        return ($this->end_page - $this->start_page + 1);
    }
}
