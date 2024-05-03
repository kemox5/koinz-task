<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiBaseController extends Controller
{
    public function success(array $data): JsonResponse
    {
        return response()->json(array_merge(['success' => true], $data), 200);
    }

    public function error(string $message, array $errors = [], int $code = 200): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $code);
    }
}
