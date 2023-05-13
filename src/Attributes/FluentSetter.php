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
     * Arguments.
     *
     * @var array<string, mixed>
     */
    private array $arguments;

    /**
     * Constructor.
     *
     * @param array<string, mixed> $arguments
     */
    public function __construct(string $name, mixed ...$arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * Returns true if the current setter name is not equal a given setter name.
     */
    public function isNotEqual(string $name): bool
    {
        return $this->name !== $name;
    }

    /**
     * Merges and returns arguments.
     *
     * @param array<string, mixed> $arguments
     *
     * @return array<string, mixed>
     */
    public function mergeArguments(array $arguments): array
    {
        return [...$this->arguments, ...$arguments];
    }
}
