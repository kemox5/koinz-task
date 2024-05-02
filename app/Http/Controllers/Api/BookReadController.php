<?php
namespace App\Http\Controllers\Api;

use App\Http\Dtos\BookReadDto;
use App\Http\Requests\Api\BookReadStoreRequest;
use App\Http\Services\Api\StoreBookReadIntervalService;

class BookReadController extends ApiBaseController
{
    /**
     * Insert a new interval for book reading.
     */
    public function store(BookReadStoreRequest $request)
    {
        $newInterval = new BookReadDto(...$request->all(['book_id', 'user_id', 'start_page', 'end_page']));

        $is_success = new StoreBookReadIntervalService($newInterval);

        if ($is_success) {

            // TODO: send sms to thanks the user

            return $this->success(['message' => 'Book read interval created successfully.']);

        } else {

            return $this->error('Book read interval creation failed.');
        
        }

    }
}
