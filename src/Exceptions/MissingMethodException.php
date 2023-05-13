<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class MissingMethodException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $method)
    {
        parent::__construct("Method $method() does not exist");
    }
}
