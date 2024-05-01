<?php

namespace App\Http\Requests;


class BookReadStoreRequest extends BaseRequest
{

    public function __construct()
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
        $rules = [
            'user_id' => ['required', 'exists:users,id', 'integer', 'min:1'],
            'book_id' => ['required', 'exists:books,id', 'integer', 'min:1'],
            'start_page' => ['required', 'integer', 'min:1', 'bail'],
            'end_page' => ['required', 'integer', 'min:' . (int) $this->get('start_page', '1')]
        ];

        return $rules;
    }
}
