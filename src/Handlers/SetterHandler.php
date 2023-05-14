<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentSetter;
use Fluent\Exceptions\NonPublicMethodException;
use ReflectionClass;

class SetterHandler extends BaseHandler
{
    /**
     * @inheritDoc
     *
     * @throws NonPublicMethodException
     */
    public function handle(): bool
    {
        $reflection = new ReflectionClass($this->class);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(FluentSetter::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var FluentSetter $fluent */
                $fluent = $attribute->newInstance();

                if ($this->getMethod() !== $fluent->getAlias()) {
                    continue;
                }

                $setter = $method->getName();

                if (! $method->isPublic()) {
                    throw new NonPublicMethodException($setter);
                }

                $this->class->$setter(...$fluent->getArguments(), ...$this->arguments);

                return true;
            }
        }

        return false;
    }
}
