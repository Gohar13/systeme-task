<?php

declare(strict_types=1);

namespace App\Component\Payment\Adapter;

use App\Component\Payment\PaymentProcessor\PaypalPaymentProcessor;
use App\Component\Payment\PaymentProcessor\StripePaymentProcessor;
use Exception;

class PaypalPaymentProcessorAdapter extends StripePaymentProcessor
{
    private PaypalPaymentProcessor $paypalProcessor;

    public function __construct(PaypalPaymentProcessor $paypalProcessor) {
        $this->paypalProcessor = $paypalProcessor;
    }

    /**
     * @throws Exception
     */
    public function processPayment(int $price): bool {

        $this->paypalProcessor->pay($price);
        return true;
    }
}
