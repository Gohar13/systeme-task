<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Request\Model;

class CalculateProductPriceData
{
    public function __construct(
        private int $productId,
        private string $taxNumber,
        private string $couponCode
    ) {}

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}