<?php

namespace App\Exceptions;

use InvalidArgumentException;

class AccountException extends InvalidArgumentException
{
    public static function emailNotFound(string $email)
    {
        return new static (__("No account found with this email address `:email`", [
            'email' => $email
        ]));
    }

    public static function invalidPassword()
    {
        return new static (__("Incorrect password"));
    }
}
