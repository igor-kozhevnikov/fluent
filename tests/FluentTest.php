<?php

declare(strict_types=1);

namespace Tests;

use Fluent\Examples\User;
use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingFluentSetterException;
use Fluent\Exceptions\NonPublicSetterException;
use Fluent\Fluent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Fluent::class)]
#[CoversClass(ExistingMethodException::class)]
#[CoversClass(MissingFluentSetterException::class)]
#[CoversClass(NonPublicSetterException::class)]
final class FluentTest extends TestCase
{
    #[Test]
    #[TestDox('Returning an instance of a class')]
    public function returnClassInstance(): void
    {
        $this->assertInstanceOf(User::class, (new User())->firstName('Igor'));
        $this->assertInstanceOf(User::class, (new User())->lastName('Kozhevnikov'));
    }

    #[Test]
    #[TestDox('Defining a property')]
    public function defineProperty(): void
    {
        $firstName = 'Igor';
        $lastName = 'Kozhevnikov';

        $this->assertSame($firstName, (new User())->firstName($firstName)->getFirstName());
        $this->assertSame($lastName, (new User())->lastName($lastName)->getLastName());
    }

    #[Test]
    #[TestDox('Throwing an exception when a fluent setter being called already exists')]
    public function existingMethod(): void
    {
        $this->expectException(ExistingMethodException::class);

        (new User())->reset(); // @phpstan-ignore-line
    }

    #[Test]
    #[TestDox('Throwing an exception when a fluent setter is missing')]
    public function missingFluentMethod(): void
    {
        $this->expectException(MissingFluentSetterException::class);

        (new User())->someMissingMethod(); // @phpstan-ignore-line
    }

    #[Test]
    #[TestDox('Throwing an exception when a setter is not public')]
    public function nonPublicMethod(): void
    {
        $this->expectException(NonPublicSetterException::class);

        (new User())->age(34);
    }
}
