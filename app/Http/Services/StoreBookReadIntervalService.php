<?php

namespace App\Http\Services;

use App\Http\Dtos\BookReadDto;
use App\Models\Book;
use App\Models\BookRead;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreBookReadIntervalService
{
    public function __construct(private BookReadDto $newInterval)
    {
        return $this->store_new_interval($newInterval);
    }


    /**
     *  Start point of the service.
     * 
     *  Check if new interval overlaps with existing intervals:
     *      1- Merge overlapping intervals with our new interval.
     *      2- Update new interval start and end pages.
     *      3- Delete old intervals.
     *      
     *  Then:   Insert new interval.
     *  Finay:  Update the book's read pages total.
     * 
     **/
    private function store_new_interval(BookReadDto $newInterval): bool
    {
        DB::beginTransaction();

        try {
            


            // Get overlapping intervals with the new interval.
            $overlappingIntervals = $this->overlapping_query()->get();
            $overlappingIntervalsPagesCount= 0;

            if ($overlappingIntervals->isNotEmpty()) {
                
                // There is overlapping intervals.
                $newInterval = $this->merge_overlapping_intervals($overlappingIntervals, $newInterval);
                $overlappingIntervalsPagesCount = $overlappingIntervals->sum('num_of_pages');
                
                $this->delete_overlapping_intervals();
            }

            $this->insert_new_interval($newInterval);

            $this->update_book_total_read_pages($newInterval, $overlappingIntervalsPagesCount);
        
        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e);

            return false;
        }

        DB::commit();

        return true;
    }


    /** 
     *      Merge overlapping intervals with our new interval.
    **/
    private function merge_overlapping_intervals(Collection $overlappingIntervals, BookReadDto $bookReadDto): BookReadDto
    {
        $start_page = min($overlappingIntervals->min('start_page'), $bookReadDto->start_page);
        $end_page = max($overlappingIntervals->max('end_page'), $bookReadDto->end_page);

        return new BookReadDto($bookReadDto->book_id, $bookReadDto->user_id, $start_page, $end_page);
    }


    /** 
     *      Delete overlapping intervals.
    **/
    private function delete_overlapping_intervals(): void
    {
        $this->overlapping_query()->delete();
    }


    /** 
     *      Insert new interval.
    **/
    private function insert_new_interval(BookReadDto $final_interval): void
    {
        BookRead::insert([
            'book_id' => $final_interval->book_id,
            'user_id' => $final_interval->user_id,
            'start_page' => $final_interval->start_page,
            'end_page' => $final_interval->end_page,
            'num_of_pages' =>  $final_interval->get_total_pages()
        ]);
    }


    /** 
     *    update book total read pages.
    **/
    private function update_book_total_read_pages(BookReadDto $final_interval, int $overlappingIntervalsPagesCount = 0): void
    {
        $book = Book::find($final_interval->book_id);
        $book->update([
            'num_of_read_pages' => $book->num_of_read_pages + $final_interval->get_total_pages() - $overlappingIntervalsPagesCount
        ]);
    }


    /**
     *  Query to get overlapping book reads
     **/
    private function overlapping_query(): \Illuminate\Database\Eloquent\Builder
    {
        $bookReadDto = $this->newInterval;

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
