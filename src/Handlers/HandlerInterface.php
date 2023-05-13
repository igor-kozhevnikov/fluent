<?php

declare(strict_types=1);

namespace Fluent\Handlers;

interface HandlerInterface
{
    /**
     * Handle.
     */
    public function handle(): void;
}
