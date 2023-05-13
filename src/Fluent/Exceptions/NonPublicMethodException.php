<?php

declare(strict_types=1);

namespace Cross\Fluent\Exceptions;

use Exception;

class NonPublicMethodException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $method)
    {
        parent::__construct("Method $method() must be public");
    }
}
