<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use App\Model\CountryInterface;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CountryInterface[]    findAll()
 */
class CountryRepository extends ServiceEntityRepository
{

    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }
}