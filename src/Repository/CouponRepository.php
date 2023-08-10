<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;

use App\Exception\CouponExpiredException;
use App\Exception\CouponNotFoundException;
use App\Model\CouponInterface;
use App\Model\ProductInterface;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 */
class CouponRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    /**
     * @throws ProductInterface
     * @throws CouponNotFoundException
     * @throws CouponExpiredException
     */
    public function getByCodeOrThrowIfUsed(string $code): CouponInterface
    {
        $coupon = $this->findOneBy(['code' => $code]);

        if (!$coupon) {
            throw new CouponNotFoundException(sprintf('Can not find coupon by code "%s"', $code));
        }

        if ($coupon->isUsed()) {
            throw new CouponExpiredException('Coupon is used already');
        }

        return $coupon;
    }

}