<?php

namespace Modules\BooksModule\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\BooksModule\Dtos\BookReadDto;
use Modules\BooksModule\Interfaces\Repositories\BookReadRepositoryInterface;
use Modules\BooksModule\Models\BookRead;

class BookReadRepository implements BookReadRepositoryInterface
{

    public function insert(BookReadDto $bookReadDto): bool
    {
        return BookRead::insert([
            'book_id' => $bookReadDto->book_id,
            'user_id' => $bookReadDto->user_id,
            'start_page' => $bookReadDto->start_page,
            'end_page' => $bookReadDto->end_page,
            'num_of_pages' =>  $bookReadDto->get_total_pages()
        ]);
    }

    /**
     *  Query to get overlapping book reads
     **/
    public function overlapping_intervals_query(BookReadDto $bookReadDto): Builder
    {
        return BookRead::query()
            ->where('book_id', $bookReadDto->book_id)
            ->where('user_id',  $bookReadDto->user_id)
            ->where(function ($query) use ($bookReadDto) {
                $query->whereBetween('start_page', [$bookReadDto->start_page, $bookReadDto->end_page])
                    ->orWhereBetween('end_page', [$bookReadDto->start_page, $bookReadDto->end_page])
                    ->orWhere(function ($query) use ($bookReadDto) {
                        $query->where('start_page', '<=', $bookReadDto->start_page)
                            ->where('end_page', '>=', $bookReadDto->end_page);
                    });
            });
    }

    public function get_overlapping_intervals(BookReadDto $bookReadDto): Collection
    {
        return $this->overlapping_intervals_query($bookReadDto)->get();
    }

    public function delete_overlapping_intervals(BookReadDto $bookReadDto): bool
    {
        return $this->overlapping_intervals_query($bookReadDto)->delete();
    }
}
