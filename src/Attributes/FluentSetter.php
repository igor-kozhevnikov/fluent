<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class FluentSetter
{
    /**
     * Name.
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
     * Returns a name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns true if the fluent name is not equal a setter name.
     */
    public function isNotEqual(string $name): bool
    {
        return $this->name !== $name;
    }

    /**
     * Returns arguments.
     *
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
