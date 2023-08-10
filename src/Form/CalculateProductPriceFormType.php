<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CalculateProductPriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'product',
                IntegerType::class,
                [
                    'required'    => true,
                    'trim'        => true,
                    'empty_data'  => '',
                    'constraints' => [
                        new NotBlank(),
                        new Type(['type' => 'integer']),
                    ],
                    'label' => 'Please fill the ID of product'
                ]
            )
            ->add(
                'taxNumber',
                TextType::class,
                [
                    'required'    => true,
                    'trim'        => true,
                    'empty_data'  => '',
                    'constraints' => [
                        new NotBlank(),
                        new Type(['type' => 'string']),
                    ],
                ]
            )
            ->add(
                'couponCode',
                TextType::class,
                [
                    'required'    => true,
                    'trim'        => true,
                    'empty_data'  => '',
                    'constraints' => [
                        new NotBlank(),
                        new Type(['type' => 'string']),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
