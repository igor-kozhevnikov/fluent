<?php

declare(strict_types=1);

namespace Tests\Fluent;

use Cross\Fluent\Exceptions\MissingMethodException;
use Cross\Fluent\Exceptions\NonPublicMethodException;
use Cross\Fluent\Exceptions\ProtectedMethodException;
use Cross\Fluent\Fluent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

#[CoversClass(Fluent::class)]
final class FluentTest extends TestCase
{
    #[Test]
    #[TestDox('Returning a class instance from a fluent method')]
    public function returnSelfInstance(): void
    {
        $fluent = (new FluentTemplate())->firstName('Mike');

        $this->assertInstanceOf(FluentTemplate::class, $fluent);
    }

    #[Test]
    #[TestDox('Getting fluent aliases')]
    public function aliases(): void
    {
        $fluent = new FluentTemplate();

        $this->assertIsCallable($fluent->getFluentAlias('idle'));
        $this->assertNull($fluent->getFluentAlias('UNDEFINED'));
    }

    #[Test]
    #[TestDox('Defining data via setters')]
    public function setter(): void
    {
        $firstName = 'Mike';
        $lastName = 'Wazowski';

        $fluent = (new FluentTemplate())
            ->firstName($firstName)
            ->lastName($lastName);

        $this->assertSame($firstName, $fluent->getFirstName());
        $this->assertSame($lastName, $fluent->getLastName());
    }

    #[Test]
    #[TestDox('Defining data via an alias')]
    public function alias(): void
    {
        $firstName = 'Mike';
        $lastName = 'Wazowski';

        $fluent = (new FluentTemplate())->name($firstName, $lastName);

        $this->assertSame("$firstName $lastName", $fluent->getFullName());
    }

    #[Test]
    #[TestDox('Defining data via non-argument setters')]
    public function nonArgumentPredefinedSetters(): void
    {
        $fluent = (new FluentTemplate())->idle();
        $this->assertSame($fluent->getStatus(), FluentTemplate::STATUS_IDLE);

        $fluent = (new FluentTemplate())->working();
        $this->assertSame($fluent->getStatus(), FluentTemplate::STATUS_WORKING);
    }

    #[Test]
    #[TestDox('Throwing an exception after calling an undefined method')]
    public function undefined(): void
    {
        $this->expectException(MissingMethodException::class);

        (new FluentTemplate())->time();
    }

    #[Test]
    #[TestDox('Throwing an exception after calling a non-public method')]
    public function nonPublic(): void
    {
        $this->expectException(NonPublicMethodException::class);

        (new FluentTemplate())->balance(100);
    }

    #[Test]
    #[TestDox('Throwing an exception after calling a protected method')]
    public function protected(): void
    {
        $this->expectException(ProtectedMethodException::class);

        (new FluentTemplate())->setBalance(100);
    }
}
