<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class CouponSaleType extends AbstractEnumType
{
    public const IN_PERCENTAGE  = 'in_percentage';
    public const FIXED          = 'fixed';

    protected static array $choices = [
        self::IN_PERCENTAGE => 'In percentage',
        self::FIXED         => 'fixed',
    ];
}