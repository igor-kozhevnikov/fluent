<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentProperty;
use Fluent\Exceptions\NonPublicPropertyException;

class PropertyHandler extends BaseHandler
{
    /**
     * Handle.
     *
     * @throws NonPublicPropertyException
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
                /** @var FluentProperty $fluent */
                $fluent = $attribute->newInstance();

                if ($this->getMethod() !== $fluent->getName() && $this->getMethod() !== $property->getName()) {
                    continue;
                }

                if (! $property->isPublic()) {
                    throw new NonPublicPropertyException($property->getName());
                }

                $value = $fluent->getValue() ?? $this->getArguments()[0] ?? null;

                $property->setValue($this->getClass(), $value);

                return true;
            }
        }

        return false;
    }
}
