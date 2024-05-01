<?php

namespace App\Http\Controllers;

use App\Http\Dtos\BookReadDto;
use App\Http\Requests\BookReadStoreRequest;
use App\Http\Services\BookReadService;
use App\Models\BookRead;
use Illuminate\Http\Request;

class BookReadController extends Controller
{
    /**
     * Insert a new interval for book reading.
     */
    public function store(BookReadStoreRequest $request, BookReadService $bookReadService)
    {
        $bookReadDto = new BookReadDto(...$request->all(['book_id', 'user_id', 'start_page', 'end_page']));

        $bookReadService = $bookReadService->store_new_interval($bookReadDto);
        
    }
}
