<?php

declare(strict_types=1);

namespace Fluent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class FluentSetter
{
    /**
     * Fluent name.
     */
    private string $fluentName;

    /**
     * Setter name.
     */
    private string $setterName;

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
        $this->fluentName = $name;
        $this->arguments = $arguments;
    }

    /**
     * Returns a fluent name.
     */
    public function getFluentName(): string
    {
        return $this->fluentName;
    }

    /**
     * Defines a setter name.
     */
    public function setSetterName(string $name): void
    {
        $this->setterName = $name;
    }

    /**
     * Returns a setter name.
     */
    public function getSetterName(): string
    {
        return $this->setterName;
    }

    /**
     * Returns true if the current setter name is not equal a given setter name.
     */
    public function isNotEqual(string $name): bool
    {
        return $this->fluentName !== $name;
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
