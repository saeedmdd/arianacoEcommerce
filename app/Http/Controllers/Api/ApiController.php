<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @param $message
     * @param $data
     * @param string $status
     * @param $error
     * @return array
     */
    private static function setApiStructure($message = null, $data = null, string $status = "ok", $error = null): array
    {
        return [
            "status" => $status,
            "data" => $data,
            "message" => $message,
            "error" => $error,
        ];
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public static function success(string $status = "ok", $message = null, $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data, $status), $code);
    }


    /**
     * @param null $message
     * @param null $data
     * @param string $status
     * @param int $code
     * @param null $error
     * @return JsonResponse
     */
    public static function error(
        $message = null,
        $data = null,
        string $status = "error",
        int $code = Response::HTTP_BAD_REQUEST,
        $error = null
    ): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data, $status, $error), $code);
    }
}
