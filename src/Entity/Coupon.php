<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\CouponInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="coupons",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="code_uniq",
 *              columns={"code"}
 *          )
 *     }
 * )
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="sale_type", type="string", length="13")
 * @ORM\DiscriminatorMap({
 *     "in_percentage"  = "App\Entity\Coupon\SaleInPercentageCoupon",
 *     "fixed"          = "App\Entity\Coupon\SaleFixedCoupon"
 * })
 *
 */
abstract class Coupon implements CouponInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="code", type="string", length="5")
     */
    private string $code;

    /**
     *
     * @ORM\Column(name="sale_value", type="float")
     */
    private float $saleValue;

    /**
     * @ORM\Column(type="boolean", options={"default"="false"})
     */
    private bool $isUsed = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSaleValue(): float
    {
        return $this->saleValue;
    }

    public function isUsed(): bool
    {
        return $this->isUsed;
    }
}
