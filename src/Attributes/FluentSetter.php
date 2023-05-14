<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class FluentSetter
{
    /**
     * Setter alias.
     */
    protected string $alias;

    /**
     * Arguments.
     *
     * @var array<array-key, mixed>
     */
    protected array $arguments;

    /**
     * Constructor.
     */
    public function __construct(string $alias, mixed ...$arguments)
    {
        $this->alias = $alias;
        $this->arguments = $arguments;
    }

    /**
     * Returns a setter alias.
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Returns arguments.
     *
     * @return array<array-key, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
