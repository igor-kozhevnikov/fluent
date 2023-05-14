<?php

declare(strict_types=1);

namespace Tests\Handlers;

use Fluent\Handlers\BaseHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(BaseHandler::class)]
final class BaseHandlerTest extends TestCase
{
    #[Test]
    #[TestDox('Defining all properties')]
    public function properties(): void
    {
        $context = new class {};
        $name = 'timeout';
        $arguments = ['min' => 0, 'max' => 100];

        $handler = new class ($context, $name, $arguments) extends BaseHandler {
            public function handle(): bool { return true; }
        };

        $reflection = new ReflectionClass($handler);

        $this->assertSame($context, $reflection->getProperty('class')->getValue($handler));
        $this->assertSame($name, $reflection->getProperty('method')->getValue($handler));
        $this->assertSame($arguments, $reflection->getProperty('arguments')->getValue($handler));
    }
}
