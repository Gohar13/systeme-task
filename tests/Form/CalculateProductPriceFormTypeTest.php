<?php

namespace App\Tests\Form;

use App\Form\CalculateProductPriceFormType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class CalculateProductPriceFormTypeTest extends TypeTestCase
{
    protected function getExtensions(): array
    {
        $validator = Validation::createValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testFormSubmissionValidData()
    {
        $formData = [
            'product' => 123,
            'taxNumber' => '123456789',
            'couponCode' => 'COUPON123',
        ];

        $form = $this->factory->create(CalculateProductPriceFormType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());

        // Check if the form view contains the expected fields
        $view = $form->createView();
        $this->assertArrayHasKey('product', $view->children);
        $this->assertArrayHasKey('taxNumber', $view->children);
        $this->assertArrayHasKey('couponCode', $view->children);
    }

    public function testFormSubmissionInvalidData()
    {
        $formData = [
           'product' => 1
        ];

        $form = $this->factory->create(CalculateProductPriceFormType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

    }
}