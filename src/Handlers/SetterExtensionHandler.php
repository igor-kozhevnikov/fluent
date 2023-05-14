<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentSetterExtension;
use Fluent\Exceptions\NonPublicMethodException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class SetterExtensionHandler extends BaseHandler
{
    /**
     * @inheritDoc
     *
     * @throws NonPublicMethodException
     * @throws ReflectionException
     */
    public function handle(): bool
    {
        $class = $this->getReflectionClass();
        $attributes = $this->fetchAttributes($this->getReflectionClass());

        if (empty($attributes)) {
            return false;
        }

        foreach ($attributes as $attribute) {
            if ($this->handleAttribute($class, $attribute->newInstance())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Fetches and returns all attributes.
     *
     * @return ReflectionAttribute[]
     */
    protected function fetchAttributes(ReflectionClass $class): array
    {
        $attributes = $class->getAttributes(FluentSetterExtension::class);

        if ($parent = $class->getParentClass()) {
            $attributes = [...$attributes, ...$this->fetchAttributes($parent)];
        }

        return $attributes;
    }

    /**
     * Handles an attribute.
     *
     * @throws ReflectionException
     * @throws NonPublicMethodException
     */
    protected function handleAttribute(ReflectionClass $class, FluentSetterExtension $attribute): bool
    {
        if ($this->getMethod() !== $attribute->getAlias()) {
            return false;
        }

        $method = $class->getMethod($attribute->getName());

        if (! $method->isPublic()) {
            throw new NonPublicMethodException($method->getName());
        }

        $attributes = [...$attribute->getArguments(), ...$this->getArguments()];

        $method->invoke($this->getClass(), ...$attributes);

        return true;
    }
}
