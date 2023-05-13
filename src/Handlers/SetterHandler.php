<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentSetter;
use Fluent\Exceptions\MissingFluentSetterException;
use Fluent\Exceptions\NonPublicSetterException;
use ReflectionClass;

class SetterHandler extends BaseHandler
{
    /**
     * @inheritDoc
     *
     * @throws MissingFluentSetterException
     * @throws NonPublicSetterException
     */
    public function handle(): void
    {
        $reflection = new ReflectionClass($this->context);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(FluentSetter::class);

            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var FluentSetter $fluent */
                $fluent = $attribute->newInstance();

                if ($fluent->isNotEqual($this->name)) {
                    continue;
                }

                $setter = $method->getName();

                if (! $method->isPublic()) {
                    throw new NonPublicSetterException($setter);
                }

                $arguments = [...$fluent->getArguments(), ...$this->arguments];

                $this->context->$setter(...$arguments);

                return;
            }
        }

        throw new MissingFluentSetterException($this->name);
    }
}
