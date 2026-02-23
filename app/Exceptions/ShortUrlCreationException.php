<?php

namespace App\Exceptions;

use Exception;

class ShortUrlCreationException extends Exception
{
    public function __construct(string $message = "Short URL could not be created")
    {
        parent::__construct($message);
    }
}
