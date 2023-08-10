<?php

declare(strict_types=1);

namespace App\Entity\Coupon;

use App\DBAL\Types\CouponSaleType;
use App\Entity\Coupon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SaleInPercentageCoupon extends Coupon
{
    public function getSaleType(): string
    {
        return CouponSaleType::IN_PERCENTAGE;
    }
}
