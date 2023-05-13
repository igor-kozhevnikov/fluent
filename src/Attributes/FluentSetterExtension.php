<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class FluentSetterExtension extends FluentSetter
{
    /**
     * Setter.
     */
    private string $setter;

    /**
     * Constructor.
     */
    public function __construct(string $setter, string $name, mixed ...$arguments)
    {
        parent::__construct($name, ...$arguments);
        $this->setter = $setter;
    }

    /**
     * Returns a setter name.
     */
    public function getSetterName(): string
    {
        return $this->setter;
    }
}
