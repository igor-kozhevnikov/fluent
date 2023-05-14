<?php

declare(strict_types=1);

namespace Tests\Handlers;

use Fluent\Handlers\BaseHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(BaseHandler::class)]
final class BaseHandlerTest extends TestCase
{
    #[Test]
    #[TestDox('Defining all properties')]
    public function properties(): void
    {
        $class = new class {};
        $method = 'timeout';
        $arguments = ['min' => 0, 'max' => 100];

        $handler = new class ($class, $method, $arguments) extends BaseHandler {
            public function handle(): bool { return true; }
        };

        $this->assertSame($class, $handler->getClass());
        $this->assertSame($method, $handler->getMethod());
        $this->assertSame($arguments, $handler->getArguments());
    }
}
