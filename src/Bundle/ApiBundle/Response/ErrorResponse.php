<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Response;

class ErrorResponse extends Response
{

    /**
     * @param string $message
     */
    public function __construct(string $message = 'InternalError')
    {
        parent::__construct($message, 500);
    }

}