<?php

namespace Modules\BooksModule\Controllers;

use App\Http\Controllers\ApiBaseController;
use Modules\BooksModule\Dtos\BookReadDto;
use Modules\BooksModule\Requests\BookReadStoreRequest;
use Modules\BooksModule\Services\StoreBookReadIntervalService;
use Plugins\SMSGateway\SMSGatewayInterface;

class BookReadController extends ApiBaseController
{
    /**
     * Insert a new interval
     * 
     * Insert a new interval for book reading.
     * 
     * @response array{success: boolean, message: string}
     */
    public function store(BookReadStoreRequest $request, StoreBookReadIntervalService $storeService)
    {
        $newInterval = new BookReadDto(...$request->all(['book_id', 'user_id', 'start_page', 'end_page']));

        if ($storeService->execute($newInterval)) {

            return $this->success(['message' => 'Book read interval created successfully.']);

        } else {

            return $this->error('Book read interval creation failed.');
        }
    }
}
