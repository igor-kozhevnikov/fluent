# Fluent

[![PHP](https://img.shields.io/badge/php-8.1-green.svg?style=flat-square)](https://github.com/igor-kozhevnikov/fluent)
[![License](https://img.shields.io/github/license/igor-kozhevnikov/fluent?style=flat-square)](https://github.com/igor-kozhevnikov/fluent)
[![Release](https://img.shields.io/github/v/release/igor-kozhevnikov/fluent?style=flat-square)](https://github.com/igor-kozhevnikov/fluent)

Easy way to add "Fluent interface" to a class.

```php
$user = User::make()
    ->fistName('Igor')
    ->lastName('Kozhevnikov')
    ->level(User::LANGUAGE_INTERMEDIATE);
```

## Install

```shell
composer required igor-kozhevnikov/fluent
```

## Examples

### Fluent method

```php
class User {
    public const STATUS_ACTIVE = 1;
    public const STATUS_BLOCKED = 2;
    
    #[FluentSetter('status')]
    #[FluentSetter('active', self::STATUS_ACTIVE)]
    #[FluentSetter('blocked', self::STATUS_BLOCKED)]
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
```

```php
$user = (new User())->status(User::STATUS_ACTIVE);
$user = (new User())->active();
$user = (new User())->blocked();
```

### Fluent property

```php
class User {
    public const LEVEL_BEGINNER = 1;
    public const LEVEL_INTERMEDIATE = 2;
    public const LEVEL_ADVANCED = 3;

    #[FluentProperty]
    #[FluentProperty('beginner', self::LEVEL_BEGINNER)]
    #[FluentProperty('intermediate', self::LEVEL_INTERMEDIATE)]
    #[FluentProperty('advanced', self::LEVEL_ADVANCED)]
    public int $level = 0;
}
```

```php
$user = (new User())->level(User::LEVEL_INTERMEDIATE);
$user = (new User())->beginner();
$user = (new User())->intermediate();
$user = (new User())->advanced();
```

## License

The Fluent is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
