<?php

namespace App\Exceptions;

use InvalidArgumentException;

class TokenException extends InvalidArgumentException
{
    public static function errorDecoding()
    {
        return new static (__('An error while decoding token.'));
    }

    public static function expiredToken()
    {
        return new static (__('Your session has expired. Please login again'));
    }
}
