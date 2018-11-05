<?php

namespace BAB\Exception;

use Throwable;

class NoResultException extends \Exception
{
    public function __construct(string $message = 'No result found', int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
