<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\Enum\PaymentProcessorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderFormType extends CalculateProductPriceFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('paymentProcessor', ChoiceType::class, [
                'choices' => PaymentProcessorType::getChoices(),
                'label' => 'Country',
            ]);


    }
}
