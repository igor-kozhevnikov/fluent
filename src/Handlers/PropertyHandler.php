<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentProperty;
use Fluent\Exceptions\NonPublicPropertyException;
use ReflectionClass;

class PropertyHandler extends BaseHandler
{
    /**
     * Handle.
     *
     * @throws NonPublicPropertyException
     */
    public function handle(): bool
    {
        $reflection = new ReflectionClass($this->class);

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(FluentProperty::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var FluentProperty $fluent */
                $fluent = $attribute->newInstance();

                if ($this->method !== $fluent->getName() && $this->method !== $property->getName()) {
                    continue;
                }

                if (! $property->isPublic()) {
                    throw new NonPublicPropertyException($property->getName());
                }

                $value = $fluent->getValue() ?? $this->arguments[0] ?? null;

                $property->setValue($this->class, $value);

                return true;
            }
        }

        return false;
    }
}
