<?php

namespace Api\Helpers;

class ResponseHelper
{
    public static function response(bool $result, ?string $message)
    {
        $message = $message ?? $result ? "Success" : "Failure";

        return ["success" => $result, "message" => $message];
    }
}