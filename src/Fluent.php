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

        $reflection = new ReflectionClass($this);

        $setterName = null;

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(FluentSetter::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var FluentSetter $fluentSetter */
                $fluentSetter = $attribute->newInstance();

                if ($fluentSetter->isNotEqual($name)) {
                    continue;
                }

                $setterName = $method->getName();

                if (! $method->isPublic()) {
                    throw new NonPublicSetterException($setterName);
                }

                break 2;
            }
        }

        if (is_null($setterName)) {
            throw new MissingFluentSetterException($name);
        }

        $this->$setterName(...$arguments);

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
        return $this->callFluentSetter($name, $arguments);
    }
}
