<?php

namespace Modules\BooksModule\Services;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\BooksModule\Dtos\BookReadDto;
use Modules\BooksModule\Interfaces\Repositories\BookReadRepositoryInterface;
use Modules\BooksModule\Interfaces\Repositories\BookRepositoryInterface;
use Modules\BooksModule\Notifications\ThankYouSMS;
class StoreBookReadIntervalService
{
    private BookReadDto $newInterval;

    public function __construct(
        private ThankYouSMS $thankYouSMS,
        private BookReadRepositoryInterface $bookReadRepository,
        private BookRepositoryInterface $bookRepository,
    ) {
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
     *  Finally:  Update the book's read pages total and send thank you sms.
     * 
     **/
    public function execute(BookReadDto $newInterval): bool
    {
        $this->newInterval = $newInterval;

        DB::beginTransaction();

        try {

            // Get overlapping intervals with the new interval.
            $overlappingIntervals = $this->bookReadRepository->get_overlapping_intervals($newInterval);
            $increment = 0;

            if ($overlappingIntervals->isNotEmpty()) {

                // There is overlapping intervals.
                $newInterval = $this->merge_overlapping_intervals($overlappingIntervals, $newInterval);
                $increment -= $overlappingIntervals->sum('num_of_pages');
            }

            $this->bookReadRepository->insert($newInterval);

            $increment += $newInterval->get_total_pages();

            $this->bookRepository->increment_total_read_pages($newInterval->book_id, $increment);

        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e);

            return false;
        }

        DB::commit();

        $this->thankYouSMS->send($newInterval->user_id);

        return true;
    }


    /** 
     *      Merge overlapping intervals with our new interval.
     **/
    private function merge_overlapping_intervals(Collection $overlappingIntervals, BookReadDto $bookReadDto): BookReadDto
    {
        $start_page = min($overlappingIntervals->min('start_page'), $bookReadDto->start_page);
        $end_page = max($overlappingIntervals->max('end_page'), $bookReadDto->end_page);

        $this->bookReadRepository->delete_overlapping_intervals($this->newInterval);

        return new BookReadDto($bookReadDto->book_id, $bookReadDto->user_id, $start_page, $end_page);
    }
}
