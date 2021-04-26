<?php

namespace Api\Helpers;

class ResponseHelper
{

    public static function response(bool $result, ?string $message)
    {
        return ["success" => $result, "message" => $message==null ? ($result ? "Success" : "Failure") : $message];
    }
}