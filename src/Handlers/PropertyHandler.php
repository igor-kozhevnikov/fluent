<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentProperty;
use ReflectionProperty;

class PropertyHandler extends BaseHandler
{
    /**
     * Handle.
     */
    public function handle(): bool
    {
        $reflection = $this->getReflectionClass();

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(FluentProperty::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                if ($this->handleAttribute($property, $attribute->newInstance())) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Handles an attribute.
     */
    protected function handleAttribute(ReflectionProperty $property, FluentProperty $attribute): bool
    {
        if ($this->getMethod() !== $attribute->getName() && $this->getMethod() !== $property->getName()) {
            return false;
        }

        $value = $attribute->getValue() ?? $this->getArguments()[0] ?? null;

        $property->setValue($this->getClass(), $value);

        return true;
    }
}
