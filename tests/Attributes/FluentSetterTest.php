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
    #[TestDox('Defining the fluent name')]
    public function fluentName(): void
    {
        $age = 'age';
        $fluent = new FluentSetter($age);

        $reflection = new ReflectionClass($fluent);
        $property = $reflection->getProperty('fluentName');

        $this->assertSame($age, $property->getValue($fluent));
        $this->assertFalse($fluent->isNotEqual($age));
        $this->assertTrue($fluent->isNotEqual('bla-bla'));
    }

    #[Test]
    #[TestDox('Defining the setter name')]
    public function setterName(): void
    {
        $setterName = 'setAge';

        $fluent = new FluentSetter('age');
        $fluent->setSetterName($setterName);

        $this->assertSame($setterName, $fluent->getSetterName());
    }

    #[Test]
    #[TestDox('Check if the name is equal the given data')]
    public function equal(): void
    {
        $fluent = new FluentSetter('time');

        $this->assertFalse($fluent->isNotEqual('time'));
        $this->assertTrue($fluent->isNotEqual('bla-bla'));
    }

    #[Test]
    #[TestDox('Merging arguments')]
    public function arguments(): void
    {
        $arguments = [true, 200, 'truth', [1, 2, 3]];
        $fluent = new FluentSetter('state', ...$arguments);

        $this->assertSame($arguments, $fluent->getArguments());
    }
}
