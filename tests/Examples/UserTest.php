<?php

declare(strict_types=1);

namespace Examples;

use Fluent\Examples\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the first name')]
    public function firstName(): void
    {
        $value = 'Igor';

        $user = new User();
        $user->setFirstName($value);

        $this->assertSame($value, $user->getFirstName());
    }

    #[Test]
    #[TestDox('Defining the last name')]
    public function lastName(): void
    {
        $value = 'Kozhevnikov';

        $user = new User();
        $user->setLastName($value);

        $this->assertSame($value, $user->getLastName());
    }

    #[Test]
    #[TestDox('Defining age')]
    public function age(): void
    {
        $value = 34;

        $user = new User();

        $reflection = new ReflectionClass($user);

        /** @see User::setAge() */
        $method = $reflection->getMethod('setAge');
        $method->invoke($user, $value);

        $this->assertSame($value, $user->getAge());
    }

    #[Test]
    #[TestDox('Checking a default status')]
    public function statusDefault(): void
    {
        $user = new User();

        $this->assertSame(User::STATUS_INACTIVE, $user->getStatus());
        $this->assertNull($user->getStatusMessage());
    }

    #[Test]
    #[TestDox('Defining a status')]
    public function testStatus(): void
    {
        $status = User::STATUS_BLOCKED;
        $message = 'Bad guy';
        $code = 100;

        $user = new User();
        $user->setStatus($status, $message, $code);

        $this->assertSame($status, $user->getStatus());
        $this->assertSame($message, $user->getStatusMessage());
        $this->assertSame($code, $user->getStatusMessageCode());
    }

    #[Test]
    #[TestDox('Defining the language level')]
    public function language(): void
    {
        $value = 100;

        $user = new User();
        $user->setLanguageLevel($value);

        $this->assertSame($value, $user->getLanguageLevel());
    }

    #[Test]
    #[TestDox('Resetting all data')]
    public function reset(): void
    {
        $user = new User();
        $user->setFirstName('Igor');
        $user->setLastName('Kozhevnikov');
        $user->setStatus(User::STATUS_ACTIVE, 'Working', 100);
        $user->setLanguageLevel(10);

        $reflection = new ReflectionClass($user);

        /** @see User::setAge() */
        $setAge = $reflection->getMethod('setAge');
        $setAge->invoke($user, 34);

        /** @see User::reset() */
        $reset = $reflection->getMethod('reset');
        $reset->invoke($user);

        $this->assertNull($user->getFirstName());
        $this->assertNull($user->getLastName());
        $this->assertNull($user->getAge());
        $this->assertSame(User::STATUS_INACTIVE, $user->getStatus());
        $this->assertNull($user->getStatusMessage());
        $this->assertNull($user->getStatusMessageCode());
        $this->assertNull($user->getLanguageLevel());
    }
}
