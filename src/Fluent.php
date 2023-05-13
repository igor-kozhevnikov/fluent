<?php

declare(strict_types=1);

namespace Fluent;

use Fluent\Attributes\FluentSetter;
use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingFluentSetterException;
use Fluent\Exceptions\NonPublicSetterException;
use ReflectionClass;

trait Fluent
{
    /**
     * Calls a fluent setter.
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingFluentSetterException
     * @throws NonPublicSetterException
     */
    protected function callFluentSetter(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            throw new ExistingMethodException($name);
        }

        $fluent = $this->findFluentSetter($name);
        $setter = $fluent->getSetterName();
        $arguments = [...$fluent->getArguments(), ...$arguments];

        $this->$setter(...$arguments);

        return $this;
    }

    /**
     * Finds a fluent setter.
     *
     * @throws NonPublicSetterException
     * @throws MissingFluentSetterException
     */
    protected function findFluentSetter(string $name): FluentSetter
    {
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(FluentSetter::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var FluentSetter $fluent */
                $fluent = $attribute->newInstance();

                if ($fluent->isNotEqual($name)) {
                    continue;
                }

                $setter = $method->getName();

                if (! $method->isPublic()) {
                    throw new NonPublicSetterException($setter);
                }

                $fluent->setSetterName($setter);

                return $fluent;
            }
        }

        throw new MissingFluentSetterException($name);
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
        return $this->callFluentSetter($name, $arguments);
    }
}
