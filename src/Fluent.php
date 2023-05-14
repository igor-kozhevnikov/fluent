<?php

declare(strict_types=1);

namespace Fluent;

use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingMethodException;
use Fluent\Exceptions\NonPublicMethodException;
use Fluent\Handlers\HandlerInterface;
use Fluent\Handlers\PropertyHandler;
use Fluent\Handlers\SetterExtensionHandler;
use Fluent\Handlers\SetterHandler;

trait Fluent
{
    /**
     * Use "Fluent Interface".
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     */
    protected function fluent(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            throw new ExistingMethodException($name);
        }

        $handlers = [
            SetterHandler::class,
            SetterExtensionHandler::class,
            PropertyHandler::class,
        ];

        /** @var class-string|HandlerInterface $handler */
        foreach ($handlers as $handler) {
            $handler = new $handler($this, $name, $arguments);

            if ($handler->handle()) {
                return $this;
            }
        }

        throw new MissingMethodException($name);
    }

    /**
     * Calls a protected or missing method.
     *
     * @param array<array-key, mixed> $arguments
     *
     * @throws ExistingMethodException
     * @throws MissingMethodException
     * @throws NonPublicMethodException
     */
    public function __call(string $name, array $arguments): self
    {
        return $this->fluent($name, $arguments);
    }
}
