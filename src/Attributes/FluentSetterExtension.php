<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class FluentSetterExtension extends FluentSetter
{
    /**
     * Setter name.
     */
    private string $name;

    /**
     * Constructor.
     */
    public function __construct(string $name, string $alias, mixed ...$arguments)
    {
        parent::__construct($alias, ...$arguments);
        $this->name = $name;
    }

    /**
     * Returns a name.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
