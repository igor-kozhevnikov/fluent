<?php

declare(strict_types=1);

namespace Tests\Attributes;

use Fluent\Attributes\FluentSetterExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(FluentSetterExtension::class)]
final class FluentSetterExtensionTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the fluent name')]
    public function fluentName(): void
    {
        $setter = 'setAge';
        $fluent = new FluentSetterExtension($setter, 'hundred', 100);

        $this->assertSame($setter, $fluent->getName());
    }
}
