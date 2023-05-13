<?php

declare(strict_types=1);

namespace Fluent;

use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingFluentSetterException;
use Fluent\Exceptions\NonPublicSetterException;
use Fluent\Handlers\SetterHandler;

trait Fluent
{
    /**
     * Use "Fluent Interface".
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingFluentSetterException
     * @throws NonPublicSetterException
     */
    protected function fluent(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            throw new ExistingMethodException($name);
        }

        (new SetterHandler($this, $name, $arguments))->handle();

        return $this;
    }

    /**
     * Calls a protected or missing method.
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingFluentSetterException
     * @throws NonPublicSetterException
     */
    public function __call(string $name, array $arguments): self
    {
        return $this->fluent($name, $arguments);
    }
}
