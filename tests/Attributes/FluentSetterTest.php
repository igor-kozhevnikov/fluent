<?php

declare(strict_types=1);

namespace Tests\Attributes;

use Fluent\Attributes\FluentSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(FluentSetter::class)]
final class FluentSetterTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the name')]
    public function naming(): void
    {
        $age = 'age';
        $attribute = new FluentSetter($age);

        $reflection = new ReflectionClass($attribute);
        $property = $reflection->getProperty('name');

        $this->assertSame($age, $property->getValue($attribute));
        $this->assertFalse($attribute->isNotEqual($age));
        $this->assertTrue($attribute->isNotEqual('bla-bla'));
    }

    #[Test]
    #[TestDox('Check if the name is equal the given data')]
    public function equal(): void
    {
        $attribute = new FluentSetter('time');

        $this->assertFalse($attribute->isNotEqual('time'));
        $this->assertTrue($attribute->isNotEqual('bla-bla'));
    }
}
