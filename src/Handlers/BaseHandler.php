<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use ReflectionClass;

abstract class BaseHandler implements HandlerInterface
{
    /**
     * Class.
     */
    private object $class;

    /**
     * Called method name.
     */
    private string $method;

    /**
     * Arguments.
     *
     * @var array<array-key, mixed>
     */
    private array $arguments = [];

    /**
     * Constructor.
     *
     * @param array<array-key, mixed> $arguments
     */
    public function __construct(object $class, string $method, array $arguments)
    {
        $this->class = $class;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Handle.
     *
     * Returns true if process finished successfully.
     */
    abstract public function handle(): bool;

    /**
     * Return a class.
     */
    public function getClass(): object
    {
        return $this->class;
    }

    /**
     * Return reflection of a class.
     */
    public function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->class);
    }

    /**
     * Return a method name.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Return arguments.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
