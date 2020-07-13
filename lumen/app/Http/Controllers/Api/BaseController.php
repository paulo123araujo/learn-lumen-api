<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function sendResponse($result, string $message, int $code = 200, $headers = [])
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, $code, $headers);
    }

    public function sendError($errorMessage, $errorLogs = [], $code = 400, $headers = [])
    {
        $response = [
            'success' => false,
            'message' => $errorMessage
        ];

        if (!empty($errorLogs)) {
            $response['data'] = $errorLogs;
        }

        return response()->json($response, $code, $headers);
    }
}
