<?php

namespace App\Traits;
use Illuminate\Support\Arr;

trait ResponseFormatter 
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages= [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function sendResponsePaginate($data, $message, $name = 'data', $code = 200)
    {
        $result = is_array($data) ? Arr::first($data) : $data;
        
        return response()->json([
            'success' => $code === 200 ? true : false,
            $name => $data,
            'message' => $message,
            'total' => $result->total(),
            'count' => $result->count(),
            'per_page' => $result->perPage(),
            'current_page' => $result->currentPage(),
            'total_pages' => $result->lastPage(),
            'next_page' => $result->nextPageUrl(),
            'prev_page' => $result->previousPageUrl(),
        ], $code);
    }
}