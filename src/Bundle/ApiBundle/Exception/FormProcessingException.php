<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Exception;

use Throwable;
use Exception;
use Symfony\Component\Form\FormInterface;

class FormProcessingException extends Exception
{

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @param FormInterface  $form
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(FormInterface $form, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

}