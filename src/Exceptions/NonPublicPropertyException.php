<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class NonPublicPropertyException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        parent::__construct("Property $$name must be public");
    }
}
