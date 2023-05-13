<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class ProtectedMethodException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $method)
    {
        parent::__construct("Method $method() is protected");
    }
}
