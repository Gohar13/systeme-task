<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Request\Model;

class MakeOrderData extends CalculateProductPriceData
{
    private string $paymentProcessor;

    public function __construct(
        int     $productId,
        string  $taxNumber,
        string  $couponCode,
        string  $paymentProcessor
    ) {
        parent::__construct($productId, $taxNumber, $couponCode);
        $this->paymentProcessor = $paymentProcessor;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}