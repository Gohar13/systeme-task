<?php

namespace App\Tests\Service;

use App\Component\Payment\PaymentProcessor\StripePaymentProcessor;
use App\Entity\Coupon\SaleInPercentageCoupon;
use App\Model\CountryInterface;
use App\Model\CouponInterface;
use App\Model\ProductInterface;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;


class ProductServiceTest extends TestCase
{
    private ProductService $productService;

    private MockObject|ProductInterface $productMock;

    private MockObject|CountryInterface $countryMock;

    private MockObject|StripePaymentProcessor $paymentProcessorMock;

    private SaleInPercentageCoupon|CouponInterface|MockObject|null $couponMock;

    protected function setUp(): void
    {
        $this->productMock = $this->createMock(ProductInterface::class);
        $this->countryMock = $this->createMock(CountryInterface::class);
        $this->paymentProcessorMock = $this->createMock(StripePaymentProcessor::class);
        $this->couponMock = $this->createMock(CouponInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepository::class);

        $this->productService = new ProductService(
            $productRepositoryMock
        );
    }

    public function testCalculateTotalPriceWithPercentageCoupon()
    {
        $this->couponMock->method('getSaleValue')->willReturn(floatval(10)); // 10% discount

        $totalPrice = $this->productService->calculateTotalPrice(
            $this->productMock,
            $this->countryMock,
            $this->couponMock
        );

        $this->assertEquals(floatval(0), $totalPrice);
    }

    public function testMakeOrderWithValidPayment()
    {
        $this->couponMock->method('getSaleValue')->willReturn(floatval(10)); // 10% discount

        $this->paymentProcessorMock->expects($this->once())
            ->method('processPayment')
            ->willReturn(true);

        $orderSuccess = $this->productService->makeOrder(
            $this->productMock,
            $this->countryMock,
            $this->paymentProcessorMock,
            $this->couponMock
        );

        $this->assertTrue($orderSuccess);
    }
}
