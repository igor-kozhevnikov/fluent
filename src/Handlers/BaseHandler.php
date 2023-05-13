<?php

declare(strict_types=1);

namespace Fluent\Handlers;

abstract class BaseHandler
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
     */
    protected array $arguments = [];

    /**
     * Constructor.
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
