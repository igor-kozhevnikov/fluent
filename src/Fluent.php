<?php

declare(strict_types=1);

namespace Fluent;

trait Fluent
{
    /**
     * Calls a protected or missing method.
     *
     * @param array<array-key, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): self
    {
        return $this;
    }
}
