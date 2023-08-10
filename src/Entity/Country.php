<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\CountryInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="countries")
 */
class Country implements CountryInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @ORM\Column(name="tax_percentage", type="float")
     */
    private float $taxPercentage;

    /**
     * @ORM\Column(name="tax_number_pattern", type="string")
     */
    private string $taxNumberPattern;


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTaxPercentage(): float
    {
        return $this->taxPercentage;
    }

    public function getTaxNumberPattern(): string
    {
        return $this->taxNumberPattern;
    }
}
