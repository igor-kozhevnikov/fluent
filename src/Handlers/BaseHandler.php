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
}
