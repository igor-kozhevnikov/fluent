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
        $setter = new FluentSetter($age);

        $reflection = new ReflectionClass($setter);
        $property = $reflection->getProperty('name');

        $this->assertSame($age, $property->getValue($setter));
        $this->assertFalse($setter->isNotEqual($age));
        $this->assertTrue($setter->isNotEqual('bla-bla'));
    }

    #[Test]
    #[TestDox('Check if the name is equal the given data')]
    public function equal(): void
    {
        $setter = new FluentSetter('time');

        $this->assertFalse($setter->isNotEqual('time'));
        $this->assertTrue($setter->isNotEqual('bla-bla'));
    }

    #[Test]
    #[TestDox('Merging arguments')]
    public function arguments(): void
    {
        $first = [true, 200, 'truth', [1, 2, 3]];
        $second = [false, 0, 'falsy', []];

        $setter = new FluentSetter('state', ...$first);

        $reflection = new ReflectionClass($setter);
        $arguments = $reflection->getProperty('arguments')->getValue($setter);

        $this->assertSame($first, $arguments);
        $this->assertSame([...$first, ...$second], $setter->mergeArguments($second));
    }
}
