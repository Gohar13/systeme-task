<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Response;

class SuccessResponse extends Response
{

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        parent::__construct('Success', 200);

        $this->data = $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        if (!$this->data) {
            return parent::jsonSerialize();
        }

        return array_merge(
            parent::jsonSerialize(),
            [
                'data' => $this->data
            ]
        );
    }

}