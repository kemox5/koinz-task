<?php

namespace App\Http\Services;

use App\Http\Dtos\BookReadDto;
use App\Http\Requests\BookReadStoreRequest;
use App\Models\Book;
use App\Models\BookRead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookReadService
{
    public function store_new_interval(BookReadDto $bookReadDto)
    {
        $book = Book::find($bookReadDto->book_id);

        $overlappingIntervals = $this->overlapping_query($bookReadDto)->get();

        if ($overlappingIntervals->isNotEmpty()) {

            $new_pages = 0;
            $min_start_page = $overlappingIntervals->min('start_page');
            $max_end_page = $overlappingIntervals->max('end_page');


            if ($bookReadDto->start_page < $min_start_page) {
                $new_pages += $min_start_page - $bookReadDto->start_page;
                $min_start_page = $bookReadDto->start_page;
            }

            if ($bookReadDto->end_page > $max_end_page) {
                $new_pages += $bookReadDto->end_page - $max_end_page;
                $max_end_page =  $bookReadDto->end_page;
            }

            $this->overlapping_query($bookReadDto)->delete();


            DB::beginTransaction();
            try {
                BookRead::insert([
                    'book_id' => $bookReadDto->book_id,
                    'user_id' => $bookReadDto->user_id,
                    'start_page' => $min_start_page,
                    'end_page' => $max_end_page
                ]);

                $book->update([
                    'num_of_read_pages' =>  $book->num_of_read_pages + $new_pages
                ]);
            } catch (Exception $e) {
                DB::rollBack();
            }

            DB::commit();
        } else {
            DB::beginTransaction();
            try {
                BookRead::insert($bookReadDto->toArray());
                $book->update([
                    'num_of_read_pages' =>  $book->num_of_read_pages + $bookReadDto->end_page - $bookReadDto->start_page + 1
                ]);
            } catch (Exception) {
                DB::rollBack();
            }
            DB::commit();
        }
    }

    public function overlapping_query(BookReadDto $bookReadDto)
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
}
