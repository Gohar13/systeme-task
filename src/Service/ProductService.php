<?php

declare(strict_types=1);

namespace App\Service;

use App\Component\Payment\PaymentProcessor\StripePaymentProcessor;
use App\Entity\Coupon\SaleInPercentageCoupon;
use App\Model\CountryInterface;
use App\Model\CouponInterface;
use App\Model\ProductInterface;
use App\Repository\ProductRepository;

class ProductService
{

    public function __construct(
        protected ProductRepository  $productRepository
    ){}

    public function calculateTotalPrice(
        ProductInterface $product,
        CountryInterface $country,
        CouponInterface $coupon = null,
    ): float
    {
        $price = $product->getPrice();
        $couponDiscount = $coupon->getSaleValue();
        $countryTax = ($price * $country->getTaxPercentage())/ 100;
        $totalPrice = abs($price + $countryTax);

        if ($coupon instanceof SaleInPercentageCoupon) {
            $discountAmount = ($totalPrice * $couponDiscount)/ 100;
            $result = $totalPrice - $discountAmount;

        } else {
            $result = $totalPrice - $couponDiscount;
        }

        return ($result < 0) ? 0 : floatval($result);
    }

    public function makeOrder(
        ProductInterface $product,
        CountryInterface $country,
        StripePaymentProcessor $paymentProcessor,
        CouponInterface $coupon = null

    ): bool
    {
        $price = $this->calculateTotalPrice($product, $country,$coupon);

        return $paymentProcessor->processPayment(intval($price));
    }
}
