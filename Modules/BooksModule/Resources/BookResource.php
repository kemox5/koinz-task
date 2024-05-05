<?php

namespace Modules\BooksModule\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this->id,
            'book_name' => $this->name,
            'num_of_read_pages' => $this->num_of_read_pages
        ];
    }
}
