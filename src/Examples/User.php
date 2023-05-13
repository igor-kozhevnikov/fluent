<?php

declare(strict_types=1);

namespace Fluent\Examples;

use Fluent\Attributes\FluentProperty;
use Fluent\Attributes\FluentSetter;
use Fluent\Fluent;

/**
 * @method self firstName(string $firstName)
 * @method self lastName(string $lastName)
 * @method self age(int $age)
 * @method self status(int $status, ?string $message = null, ?int $code = null)
 * @method self active()
 * @method self blocked(?string $message = null, ?int $code = null)
 * @method self language(int $level)
 * @method self level(int $level)
 * @method self beginner()
 * @method self intermediate()
 * @method self advanced()
 * @method self cash(float $cash)
 */
final class User
{
    use Fluent;

    /**
     * User is inactive.
     */
    public const STATUS_INACTIVE = 0;

    /**
     * User is active.
     */
    public const STATUS_ACTIVE = 1;

    /**
     * User is blocked.
     */
    public const STATUS_BLOCKED = 2;

    /**
     * Beginner language level.
     */
    public const LANGUAGE_BEGINNER = 1;

    /**
     * Intermediate language level.
     */
    public const LANGUAGE_INTERMEDIATE = 2;

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
     * Status.
     */
    private int $status = self::STATUS_INACTIVE;

    /**
     * Status message.
     */
    private ?string $statusMessage = null;

    /**
     * Status message code.
     */
    private ?int $statusMessageCode = null;

    /**
     * Language level.
     */
    #[FluentProperty]
    #[FluentProperty('level')]
    #[FluentProperty('beginner', self::LANGUAGE_BEGINNER)]
    #[FluentProperty('intermediate', self::LANGUAGE_INTERMEDIATE)]
    public ?int $language = null;

    /**
     * Balance
     */
    #[FluentProperty('cash')]
    private ?float $balance = 0.0;

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
     * Returns age.
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Defines a status.
     */
    #[FluentSetter('status')]
    #[FluentSetter('active', self::STATUS_ACTIVE)]
    #[FluentSetter('blocked', self::STATUS_BLOCKED)]
    public function setStatus(int $status, ?string $message = null, ?int $code = null): void
    {
        $this->status = $status;
        $this->statusMessage = $message;
        $this->statusMessageCode = $code;
    }

    /**
     * Returns the status.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Returns the status message.
     */
    public function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    /**
     * Returns the status message.
     */
    public function getStatusMessageCode(): ?int
    {
        return $this->statusMessageCode;
    }

    /**
     * Defines the language level.
     */
    public function setLanguageLevel(int $level): void
    {
        $this->language = $level;
    }

    /**
     * Returns the language level.
     */
    public function getLanguageLevel(): ?int
    {
        return $this->language;
    }

    /**
     * Reset data.
     */
    protected function reset(): void
    {
        $this->firstName = null;
        $this->lastName = null;
        $this->age = null;
        $this->status = self::STATUS_INACTIVE;
        $this->statusMessage = null;
        $this->statusMessageCode = null;
        $this->language = null;
    }
}
