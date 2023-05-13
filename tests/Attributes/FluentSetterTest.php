<?php

declare(strict_types=1);

namespace Tests\Attributes;

use Fluent\Attributes\FluentSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(FluentSetter::class)]
final class FluentSetterTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the fluent name')]
    public function fluentName(): void
    {
        $age = 'age';
        $fluent = new FluentSetter($age);

        $this->assertSame($age, $fluent->getName());
        $this->assertFalse($fluent->isNotEqual($age));
        $this->assertTrue($fluent->isNotEqual('bla-bla'));
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
