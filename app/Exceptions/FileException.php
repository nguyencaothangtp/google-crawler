<?php

namespace App\Exceptions;

use InvalidArgumentException;

class FileException extends InvalidArgumentException
{
    public static function notFound()
    {
        return new static (__("File not found"));
    }

    public static function notSupportedExtension()
    {
        return new static (__("File extension not supported"));
    }
}
