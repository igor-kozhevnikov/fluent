<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class NonPublicSetterException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        parent::__construct("Setter $name() must be public");
    }
}
