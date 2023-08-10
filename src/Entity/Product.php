<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="products")
 */
class Product implements ProductInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @var float
     *
     * @ORM\Column(name="rice", type="decimal", precision=19, scale=4)
     */
    private float $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
