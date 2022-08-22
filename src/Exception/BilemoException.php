<?php

namespace App\Exception;

use Exception;

class BilemoException extends Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
