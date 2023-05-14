<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentSetter;
use Fluent\Exceptions\NonPublicMethodException;
use ReflectionException;
use ReflectionMethod;

class SetterHandler extends BaseHandler
{
    /**
     * @inheritDoc
     *
     * @throws NonPublicMethodException
     * @throws ReflectionException
     */
    public function handle(): bool
    {
        $reflection = $this->getReflectionClass();

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(FluentSetter::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                if ($this->handleAttribute($method, $attribute->newInstance())) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Handles an attribute.
     *
     * @throws NonPublicMethodException
     * @throws ReflectionException
     */
    protected function handleAttribute(ReflectionMethod $method, FluentSetter $attribute): bool
    {
        if ($this->getMethod() !== $attribute->getAlias()) {
            return false;
        }

        if (! $method->isPublic()) {
            throw new NonPublicMethodException($method->getName());
        }

        $attributes = [...$attribute->getArguments(), ...$this->getArguments()];

        $method->invoke($this->getClass(), ...$attributes);

        return true;
    }
}
