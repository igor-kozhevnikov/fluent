<?php

declare(strict_types=1);

namespace Fluent\Exceptions;

use Exception;

class MissingFluentSetterException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        parent::__construct("Fluent setter $name() is missing");
    }
}
