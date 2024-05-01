<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
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
