<?php

namespace App\Exceptions;

use InvalidArgumentException;

class KeywordStatsException extends InvalidArgumentException
{
    public static function notFound()
    {
        return new static (__("Keyword statistic not found"));
    }
}
