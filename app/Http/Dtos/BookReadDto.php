<?php

namespace App\Http\Dtos;

use Illuminate\Http\Request;

class BookReadDto extends Dto
{

    public function __construct(public readonly int $book_id, public readonly int $user_id, public readonly int $start_page, public readonly int $end_page)
    {
        
    }
}
