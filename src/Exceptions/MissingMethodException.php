<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class MissingMethodException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        parent::__construct("Method $name() is missing");
    }
}
