<?php

declare(strict_types=1);

namespace Fluent;

use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingMethodException;
use Fluent\Exceptions\NonPublicMethodException;
use Fluent\Handlers\PropertyHandler;
use Fluent\Handlers\SetterExtensionHandler;
use Fluent\Handlers\SetterHandler;
use ReflectionException;

trait Fluent
{
    /**
     * Use "Fluent Interface".
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     * @throws ReflectionException
     */
    protected function fluent(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            throw new ExistingMethodException($name);
        }

        $isFind = (new SetterHandler($this, $name, $arguments))->handle();
        $isFind = $isFind || (new SetterExtensionHandler($this, $name, $arguments))->handle();
        $isFind = $isFind || (new PropertyHandler($this, $name, $arguments))->handle();

        if ($isFind) {
            return $this;
        }

        throw new MissingMethodException($name);
    }

    /**
     * Calls a protected or missing method.
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     * @throws ReflectionException
     */
    public function __call(string $name, array $arguments): self
    {
        return $this->fluent($name, $arguments);
    }
}
