<?php

namespace App\Exceptions;

use App\Http\Controllers\ApiBaseController;
use Exception;
use Illuminate\Contracts\Validation\Validator;

class ApiValidationException extends Exception
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = 422;

    public function __construct(private Validator $validator)
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return (new ApiBaseController)->error('Validation errors', $this->validator->errors()->getMessages(), 422);
    }

    
    public function report(){

    }
}
