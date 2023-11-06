<?php

namespace AdityaDarma\LaravelServiceRepository\Exception;

use Exception;

class CustomException extends Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message = "", $code = 0, $previous = null);
    }
}