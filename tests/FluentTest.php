<?php

declare(strict_types=1);

namespace Tests;

use Fluent\Exceptions\ExistingMethodException;
use Fluent\Exceptions\MissingMethodException;
use Fluent\Exceptions\NonPublicMethodException;
use Fluent\Exceptions\NonPublicPropertyException;
use Fluent\Fluent;
use Fluent\Handlers\PropertyHandler;
use Fluent\Handlers\SetterExtensionHandler;
use Fluent\Handlers\SetterHandler;
use Fluent\Examples\Client;
use Fluent\Examples\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Fluent::class)]
#[CoversClass(SetterHandler::class)]
#[CoversClass(SetterExtensionHandler::class)]
#[CoversClass(PropertyHandler::class)]
#[CoversClass(ExistingMethodException::class)]
#[CoversClass(MissingMethodException::class)]
#[CoversClass(NonPublicMethodException::class)]
#[CoversClass(NonPublicPropertyException::class)]
final class FluentTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the first name')]
    public function firstName(): void
    {
        $firstName = 'Igor';

        $this->assertInstanceOf(User::class, (new User())->firstName($firstName));
        $this->assertSame($firstName, (new User())->firstName($firstName)->getFirstName());
    }

    #[Test]
    #[TestDox('Defining the last name')]
    public function lastName(): void
    {
        $lastName = 'Kozhevnikov';

        $this->assertInstanceOf(User::class, (new User())->lastName($lastName));
        $this->assertSame($lastName, (new User())->lastName($lastName)->getLastName());
    }

    #[Test]
    #[TestDox('Defining the status by an argument')]
    public function statusViaArgument(): void
    {
        $status = User::STATUS_ACTIVE;
        $message = 'Verified successfully';

        $this->assertInstanceOf(User::class, (new User())->status($status, $message));
        $this->assertSame($status, (new User())->status($status)->getStatus());
        $this->assertSame($message, (new User())->status($status, $message)->getStatusMessage());
    }

    #[Test]
    #[TestDox('Defining the active status')]
    public function statusActive(): void
    {
        $status = User::STATUS_ACTIVE;

        $this->assertInstanceOf(User::class, (new User())->active());
        $this->assertSame($status, (new User())->active()->getStatus());
    }

    #[Test]
    #[TestDox('Defining the blocked status without an argument')]
    public function statusBlocked(): void
    {
        $status = User::STATUS_BLOCKED;
        $message = 'The verification period has expired';
        $code = 150;

        $this->assertInstanceOf(User::class, (new User())->blocked($message));
        $this->assertSame($status, (new User())->blocked()->getStatus());
        $this->assertSame($message, (new User())->blocked(message: $message)->getStatusMessage());
        $this->assertSame($code, (new User())->blocked(code: $code)->getStatusMessageCode());
    }

    #[Test]
    #[TestDox('Defining the VIP status')]
    public function statusVip(): void
    {
        $this->assertInstanceOf(Client::class, (new Client())->vip());
        $this->assertSame(Client::STATUS_VIP, (new Client())->vip()->getStatus());
    }

    #[Test]
    #[TestDox('Defining other statuses')]
    public function statusExtensions(): void
    {
        $this->assertSame(Client::STATUS_VIP, (new Client())->status(Client::STATUS_VIP)->getStatus());
        $this->assertSame(User::STATUS_ACTIVE, (new Client())->active()->getStatus());
        $this->assertSame(User::STATUS_BLOCKED, (new Client())->blocked()->getStatus());
    }

    #[Test]
    #[TestDox('Defining the language')]
    public function language(): void
    {
        $language = 10;

        $this->assertInstanceOf(User::class, (new User())->language($language));
        $this->assertSame($language, (new User())->language($language)->getLanguageLevel());
    }

    #[Test]
    #[TestDox('Defining the language by a synonym')]
    public function level(): void
    {
        $level = 10;

        $this->assertInstanceOf(User::class, (new User())->level($level));
        $this->assertSame($level, (new User())->level($level)->getLanguageLevel());
    }

    #[Test]
    #[TestDox('Defining the language as beginner')]
    public function languageBeginner(): void
    {
        $this->assertInstanceOf(User::class, (new User())->beginner());
        $this->assertSame(User::LANGUAGE_BEGINNER, (new User())->beginner()->getLanguageLevel());
    }

    #[Test]
    #[TestDox('Defining the language as intermediate')]
    public function languageIntermediate(): void
    {
        $this->assertInstanceOf(User::class, (new User())->intermediate());
        $this->assertSame(User::LANGUAGE_INTERMEDIATE, (new User())->intermediate()->getLanguageLevel());
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
        $this->expectException(MissingMethodException::class);

        (new User())->someMissingMethod(); // @phpstan-ignore-line
    }

    #[Test]
    #[TestDox('Throwing an exception when a fluent setter is missing (extension)')]
    public function missingFluentMethodFromExtension(): void
    {
        $this->expectException(MissingMethodException::class);

        (new Client())->someMissingMethod(); // @phpstan-ignore-line
    }

    #[Test]
    #[TestDox('Throwing an exception when a setter is not public')]
    public function nonPublicMethod(): void
    {
        $this->expectException(NonPublicMethodException::class);

        (new User())->age(34);
    }

    #[Test]
    #[TestDox('Throwing an exception when a setter is not public (extension)')]
    public function nonPublicMethodFromExtension(): void
    {
        $this->expectException(NonPublicMethodException::class);

        (new Client())->hundred();
    }

    #[Test]
    #[TestDox('Throwing an exception when a property is not public')]
    public function nonPublicProperty(): void
    {
        $this->expectException(NonPublicPropertyException::class);

        (new User())->cash(100.0);
    }
}
