<?php

declare(strict_types=1);

namespace Fluent\Examples;

use Fluent\Attributes\FluentSetter;
use Fluent\Fluent;

/**
 * @method self firstName(string $firstName)
 * @method self lastName(string $lastName)
 * @method self age(int $age)
 */
class User
{
    use Fluent;

    /**
     * First name.
     */
    private ?string $firstName = null;

    /**
     * Last name.
     */
    private ?string $lastName = null;

    /**
     * Age.
     */
    private ?int $age = null; // @phpstan-ignore-line

    /**
     * Defines the first name.
     */
    #[FluentSetter('firstName')]
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the first name.
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Defines the last name.
     */
    #[FluentSetter('lastName')]
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns the last name.
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Defines age.
     */
    #[FluentSetter('age')]
    protected function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * Reset data.
     */
    protected function reset(): void
    {
        $this->firstName = null;
        $this->lastName = null;
        $this->age = null;
    }
}
