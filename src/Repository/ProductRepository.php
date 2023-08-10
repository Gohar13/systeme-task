<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use App\Model\ProductInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 */
class ProductRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ProductInterface
     * @throws ProductNotFoundException
     */
    public function getByIdOrThrowIfMissing(int $id): ProductInterface
    {
        $product = $this->findOneBy(['id' => $id]);

        if (!$product) {
            throw new ProductNotFoundException(sprintf('Can not find product by id "%s"', $id));
        }

        return $product;
    }

}