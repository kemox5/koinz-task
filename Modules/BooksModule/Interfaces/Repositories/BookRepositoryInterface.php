<?php

namespace Modules\BooksModule\Interfaces\Repositories;

interface BookRepositoryInterface{
    public function getById(int $id);
    public function increment_total_read_pages(int $id, int $increment): bool;
}
