<?php

declare(strict_types=1);

namespace Fluent\Handlers;

abstract class BaseHandler implements HandlerInterface
{
    /**
     * Context.
     */
    protected object $context;

    /**
     * Called method name.
     */
    protected string $name;

    /**
     * Arguments.
     *
     * @var array<array-key, mixed>
     */
    protected array $arguments = [];

    /**
     * Constructor.
     *
     * @param array<array-key, mixed> $arguments
     */
    public function __construct(object $context, string $name, array $arguments)
    {
        $this->context = $context;
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * Handle.
     *
     * Returns true if process finished successfully.
     */
    abstract public function handle(): bool;
}
