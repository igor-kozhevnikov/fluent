<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class NonPublicMethodException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        parent::__construct("Method $name() must be public");
    }
}
