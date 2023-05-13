<?php

declare(strict_types=1);

namespace Fluent\Handlers;

interface HandlerInterface
{
    /**
     * Constructor.
     *
     * @param array<array-key, mixed> $arguments
     */
    public function __construct(object $context, string $name, array $arguments);

    /**
     * Handle.
     *
     * Returns true if process finished successfully.
     */
    public function handle(): bool;
}
