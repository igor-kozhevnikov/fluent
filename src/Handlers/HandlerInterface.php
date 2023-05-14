<?php

declare(strict_types=1);

namespace Fluent\Handlers;

interface HandlerInterface
{
    /**
     * Handle.
     *
     * Returns true if process finished successfully.
     */
    public function handle(): bool;
}
