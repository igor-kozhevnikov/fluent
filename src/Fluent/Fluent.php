<?php

declare(strict_types=1);

namespace Cross\Fluent;

use Closure;
use Cross\Fluent\Exceptions\MissingMethodException;
use Cross\Fluent\Exceptions\NonPublicMethodException;
use Cross\Fluent\Exceptions\ProtectedMethodException;
use ReflectionMethod;

trait Fluent
{
    /**
     * Returns a fluent alise for a setter.
     */
    protected function getFluentAlias(string $name): ?Closure
    {
        return null;
    }

    /**
     * Returns a fluent setter.
     *
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     */
    protected function getFluentSetter(string $name): Closure
    {
        $method = 'set' . ucfirst($name);

        if (! method_exists($this, $method)) {
            throw new MissingMethodException($method);
        }

        $reflection = new ReflectionMethod($this, $method);

        if (! $reflection->isPublic()) {
            throw new NonPublicMethodException($reflection->getName());
        }

        return $this->$method(...);
    }

    /**
     * Calls a method.
     *
     * @param array<array-key, mixed>  $arguments
     *
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     * @throws ProtectedMethodException
     */
    public function __call(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            throw new ProtectedMethodException($name);
        }

        $method = $this->getFluentAlias($name);

        if (is_null($method)) {
            $method = $this->getFluentSetter($name);
        }

        $arguments[] = $name;

        $method(...$arguments);

        return $this;
    }
}
