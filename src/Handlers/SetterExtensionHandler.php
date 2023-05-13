<?php

declare(strict_types=1);

namespace Fluent\Handlers;

use Fluent\Attributes\FluentSetterExtension;
use Fluent\Exceptions\NonPublicMethodException;
use ReflectionClass;

class SetterExtensionHandler extends BaseHandler
{
    /**
     * @inheritDoc
     *
     * @throws NonPublicMethodException
     */
    public function handle(): bool
    {
        $reflection = new ReflectionClass($this->context);
        $attributes = $reflection->getAttributes(FluentSetterExtension::class);

//        if (empty($attributes) && $parent = $reflection->getParentClass()) {
//            $attributes = $parent->getAttributes(FluentSetterExtension::class);
//        }

        if (empty($attributes)) {
            if ($parent = $reflection->getParentClass()) {
                return (new self($parent, $this->name, $this->arguments))->handle();
            }

            return false;
        }

        foreach ($attributes as $attribute) {
            /** @var FluentSetterExtension $fluent */
            $fluent = $attribute->newInstance();

            if ($this->name !== $fluent->getName()) {
                continue;
            }

            $method = $reflection->getMethod($fluent->getSetterName());

            if (! $method->isPublic()) {
                throw new NonPublicMethodException($method->getName());
            }

            $method->invoke($this->context, ...$fluent->getArguments(), ...$this->arguments);

            return true;
        }

        return false;
    }
}
