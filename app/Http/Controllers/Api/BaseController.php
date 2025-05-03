<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
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

    public function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika diawali dengan +62 atau 62, hapus kode negara
        if (str_starts_with($phone, '+62')) {
            $phone = substr($phone, 3); // Hapus +62
        } elseif (str_starts_with($phone, '62')) {
            $phone = substr($phone, 2); // Hapus 62
        }

        // Pastikan nomor dimulai dengan 0
        if (!str_starts_with($phone, '0')) {
            $phone = '0' . $phone;
        }

        // Minimum 10 digit (termasuk 0 di depan)
        if (strlen($phone) < 10) {
            throw new \Exception('Invalid phone number length');
        }

        return $phone;
    }
}
