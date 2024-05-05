<?php

namespace Modules\BooksModule\Interfaces\Repositories;

use Modules\BooksModule\Dtos\BookReadDto;

interface BookReadRepositoryInterface{
    public function get_overlapping_intervals(BookReadDto $bookReadDto);

    public function delete_overlapping_intervals(BookReadDto $bookReadDto);

    public function insert(BookReadDto $bookReadDto);
}
