<?php

declare(strict_types=1);

namespace Fluent\Examples;

use Fluent\Attributes\FluentSetterExtension;

/**
 * @method self vip()
 * @method self hundred()
 */
#[FluentSetterExtension('setStatus', 'vip', self::STATUS_VIP)]
#[FluentSetterExtension('setAge', 'hundred', 100)]
class Client extends User
{
    /**
     * User is VIP.
     */
    public const STATUS_VIP = 3;
}
