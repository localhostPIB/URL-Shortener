<?php

namespace App\Exceptions;

use Exception;

class QRCodeCreationException extends Exception
{
    public function __construct(string $message = "QRCode could not be created")
    {
        parent::__construct($message);
    }
}
