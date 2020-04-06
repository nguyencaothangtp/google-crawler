<?php

namespace App\Exceptions;

use InvalidArgumentException;

class CrawlException extends InvalidArgumentException
{
    public static function error(string $error)
    {
        return new static ($error);
    }
}
