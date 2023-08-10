<?php

declare(strict_types=1);

namespace App\Component\Payment\Factory;

use App\Component\Payment\Adapter\PaypalPaymentProcessorAdapter;
use App\Component\Payment\PaymentProcessor\PaypalPaymentProcessor;
use App\Component\Payment\PaymentProcessor\StripePaymentProcessor;
use Exception;

class PaymentProcessorFactory
{
    /**
     * @throws Exception
     */
    public function createProduct($type): StripePaymentProcessor
    {
        $processor = match ($type) {
            'paypal' => new PaypalPaymentProcessorAdapter(new PaypalPaymentProcessor()),
            'stripe' => new StripePaymentProcessor(),
            default => throw new Exception("Invalid processor type"),
        };

        if (!is_a($processor, StripePaymentProcessor::class, true)) {
            throw new Exception("Class should extend StripePaymentProcessor.");
        }

        return $processor;
    }
}
