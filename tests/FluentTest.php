<?php

declare(strict_types=1);

namespace Tests;

use Fluent\Fluent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Fluent::class)]
final class FluentTest extends TestCase
{
    #[Test]
    #[TestDox('...')]
    public function _(): void
    {
        $this->assertTrue(true);
    }
}
