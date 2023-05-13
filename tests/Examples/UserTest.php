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

        $setter = $reflection->getMethod('setAge');
        $setter->invoke($user, $value);

        $property = $reflection->getProperty('age');

        $this->assertSame($value, $property->getValue($user));
    }

    #[Test]
    #[TestDox('Resetting all data')]
    public function reset(): void
    {
        $user = new User();
        $user->setFirstName('Igor');
        $user->setLastName('Kozhevnikov');

        $reflection = new ReflectionClass($user);

        $setAge = $reflection->getMethod('setAge');
        $setAge->invoke($user, 34);

        $age = $reflection->getProperty('age');

        $reset = $reflection->getMethod('reset');
        $reset->invoke($user);

        $this->assertNull($user->getFirstName());
        $this->assertNull($user->getLastName());
        $this->assertNull($age->getValue($user));
    }
}
