<?php

namespace Api\Helpers;

/**
 * Class ResponseHelper
 * @package Api\Helpers
 */
class ResponseHelper
{

    /**
     * @param bool $result
     * @param string|null $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response(bool $result, ?string $message = null)
    {
        return response()->json([
            'success' => $result,
            'message' => $message === null ? ($result ? 'Success' : 'Failure') : $message,
        ]);
    }

    /**
     * @param string|null $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failure(?string $message = null)
    {
        return self::response(false, $message);
    }

    /**
     * @param string|null $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(?string $message = null)
    {
        return self::response(true, $message);
    }
}