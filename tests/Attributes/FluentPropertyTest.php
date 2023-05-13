<?php

declare(strict_types=1);

namespace Tests\Attributes;

use Fluent\Attributes\FluentProperty;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(FluentProperty::class)]
final class FluentPropertyTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a name')]
    public function fluentName(): void
    {
        $name = 'name';
        $fluent = new FluentProperty($name);

        $this->assertSame($name, $fluent->getName());
    }

    #[Test]
    #[TestDox('Defining a value')]
    public function fluentValue(): void
    {
        $value = 'Igor';
        $fluent = new FluentProperty(value: $value);

        $this->assertSame($value, $fluent->getValue());
    }
}
