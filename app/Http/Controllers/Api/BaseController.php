<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="Laundry API",
     *     description="API for Laundry Management System",
     *     @OA\Contact(
     *         email="support@gmail.com"
     *     )
     * )
     * @OA\Server(
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="API Server"
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     securityScheme="sanctum",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     */
    public function __construct() {}

    public function sendResponse($result, $message)
    {
        $response = array(
            'success' => true,
            'data' => $result,
            'message' => $message
        );

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = array(
            'success' => false,
            'message' => $error
        );

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
