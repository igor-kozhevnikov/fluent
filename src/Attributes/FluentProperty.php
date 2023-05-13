<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class FluentProperty
{
    /**
     * Name.
     */
    private ?string $name;

    /**
     * Value.
     */
    private mixed $value;

    /**
     * Constructor.
     */
    public function __construct(?string $name = null, mixed $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Returns a fluent name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Returns a value.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
