<?php

namespace App\Http\Controllers;

use App\Http\Dtos\BookReadDto;
use App\Http\Requests\BookReadStoreRequest;
use App\Http\Services\StoreBookReadIntervalService;

class BookReadController extends ApiController
{
    /**
     * Insert a new interval for book reading.
     */
    public function store(BookReadStoreRequest $request)
    {
        $newInterval = new BookReadDto(...$request->all(['book_id', 'user_id', 'start_page', 'end_page']));

        $is_success = new StoreBookReadIntervalService($newInterval);

        if ($is_success) {

            return $this->success(['message' => 'Book read interval created successfully.']);

        } else {

            return $this->error('Book read interval creation failed.');
        
        }

    }
}
