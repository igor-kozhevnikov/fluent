<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class FluentSetter
{
    /**
     * Setter name.
     */
    private string $name;

    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns true if the current setter name is not equal a given setter name.
     */
    public function isNotEqual(string $name): bool
    {
        return $this->name !== $name;
    }
}
