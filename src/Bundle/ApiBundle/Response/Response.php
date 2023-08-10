<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Response;

use JsonSerializable;

abstract class Response implements JsonSerializable
{

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $httpCode;

    /**
     * @param string   $message
     * @param int      $code
     * @param int|null $httpCode
     */
    public function __construct(string $message, int $code, int $httpCode = null)
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->httpCode = $httpCode ?? $code;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param  string $message
     *
     * @return static
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'code'    => $this->code,
            'message' => $this->message
        ];
    }

}