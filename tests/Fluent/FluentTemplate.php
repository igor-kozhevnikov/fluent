<?php

declare(strict_types=1);

namespace Tests\Fluent;

use Closure;
use Cross\Fluent\Fluent;

/**
 * @method self name(?string $firstName, ?string $lastName)
 * @method self firstName(?string $firstName)
 * @method self lastName(?string $lastName)
 * @method self time()
 * @method self balance(float $balance)
 * @method self status(int|string $status)
 * @method self idle()
 * @method self working()
 */
class FluentTemplate
{
    use Fluent;

    /**
     * Person is idle.
     */
    public const STATUS_IDLE = 1;

    /**
     * Person is working.
     */
    public const STATUS_WORKING = 2;

    /**
     * First name.
     */
    private ?string $firstName = null;

    /**
     * Last name.
     */
    private ?string $lastName = null;

    /**
     * Balance.
     */
    private float $balance = 0.0;

    /**
     * Status.
     */
    private int $status = self::STATUS_IDLE;

    /**
     * @inheritDoc
     */
    public function getFluentAlias(string $name): ?Closure
    {
        return match ($name) {
            'name' => $this->setFullName(...),
            'idle' => fn() => $this->setStatus(self::STATUS_IDLE),
            'working' => fn() => $this->setStatus(self::STATUS_WORKING),
            default => null,
        };
    }

    /**
     * Defines the full name.
     */
    public function setFullName(?string $firstName, ?string $lastName): void
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    /**
     * Returns the full name.
     */
    public function getFullName(): string
    {
        return "$this->firstName $this->lastName";
    }

    /**
     * Defines the first name.
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the first name.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Defines the last name.
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns the last name.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Defines the balance.
     */
    protected function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * Returns the balance.
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Defines the status.
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns the status.
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
