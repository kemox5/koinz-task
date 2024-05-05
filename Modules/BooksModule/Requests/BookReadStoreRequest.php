<?php

namespace Modules\BooksModule\Requests;

use App\Http\Requests\ApiBaseRequest;
use Modules\BooksModule\Interfaces\Repositories\BookRepositoryInterface;
use Modules\BooksModule\Models\Book;

class BookReadStoreRequest extends ApiBaseRequest
{
    private ?Book $book = null;

    public function __construct(private BookRepositoryInterface $bookRepository)
    {
        parent::__construct();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if ($this->book_id) {
            $this->book = $this->bookRepository->getById((int)$this->book_id);
        }

        $rules = [
            'user_id' => ['required', 'exists:users,id', 'integer', 'min:1'],
            'book_id' => ['required', 'exists:books,id', 'integer', 'min:1'],
            'start_page' => ['required', 'integer', 'min:1'],
            'end_page' => ['required', 'integer', 'gte:start_page', 'min:1']
        ];

        if ($this->book) {
            $rules['start_page'][] = 'lte:' . $this->book->num_of_pages;
            $rules['end_page'][] = 'lte:' . $this->book->num_of_pages;
        }

        return $rules;
    }
}
