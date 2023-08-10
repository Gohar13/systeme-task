<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Bundle\ApiBundle\Controller\ApiController as BaseApiController;

abstract class ApiController extends BaseApiController
{

    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $data
     * @param array $context
     *
     * @return string|int|bool|\ArrayObject|array|float|null
     * @throws ExceptionInterface
     */
    protected function getNormalizedData(mixed $data, array $context = []): string|int|bool|\ArrayObject|array|null|float
    {
        return $this->serializer->normalize($data, null, $context);
    }
}