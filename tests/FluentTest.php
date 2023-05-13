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
        $this->assertInstanceOf(User::class, (new User())->status(User::STATUS_ACTIVE));
        $this->assertInstanceOf(User::class, (new User())->active());
        $this->assertInstanceOf(User::class, (new User())->blocked());
    }

    #[Test]
    #[TestDox('Defining a property without arguments')]
    public function definePropertyWithoutArguments(): void
    {
        $firstName = 'Igor';
        $lastName = 'Kozhevnikov';
        $status = User::STATUS_ACTIVE;
        $active = User::STATUS_ACTIVE;
        $blocked = User::STATUS_BLOCKED;

        $this->assertSame($firstName, (new User())->firstName($firstName)->getFirstName());
        $this->assertSame($lastName, (new User())->lastName($lastName)->getLastName());
        $this->assertSame($status, (new User())->status($status)->getStatus());
        $this->assertSame($active, (new User())->active()->getStatus());
        $this->assertSame($blocked, (new User())->blocked()->getStatus());
    }

    #[Test]
    #[TestDox('Defining a property with arguments')]
    public function definePropertyWithArguments(): void
    {
        $statusMessage = 'Verified successfully';
        $blockedMessage = 'The verification period has expired';

        $this->assertSame($statusMessage, (new User())->status(User::STATUS_ACTIVE, $statusMessage)->getStatusMessage());
        $this->assertSame($blockedMessage, (new User())->blocked($blockedMessage)->getStatusMessage());
    }

    #[Test]
    #[TestDox('Defining a property with selected arguments')]
    public function definePropertyWithSelectedArguments(): void
    {
        $message = 'Verified unsuccessfully';
        $code = 150;

        $this->assertSame($message, (new User())->blocked($message)->getStatusMessage());
        $this->assertSame($message, (new User())->blocked(message: $message)->getStatusMessage());

        $this->assertSame($code, (new User())->blocked($message, code: $code)->getStatusMessageCode());
        $this->assertSame($code, (new User())->blocked(code: $code)->getStatusMessageCode());

        $this->assertSame($code, (new User())->blocked(message: $message, code: $code)->getStatusMessageCode());
        $this->assertSame($message, (new User())->blocked(code: $code, message: $message)->getStatusMessage());
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
