<?php

namespace BAB\Exception;

use Throwable;

class MultipleResultsException extends \Exception
{
    public function __construct(string $message = 'Multiples results found', int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
