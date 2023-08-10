<?php

namespace App\Form\Enum;

class PaymentProcessorType
{
    const PAYPAL = 'paypal';
    const STRIPE = 'stripe';

    public static function getChoices(): array
    {
        return [
            'Paypal' => self::PAYPAL,
            'Stripe' => self::STRIPE,
        ];
    }
}