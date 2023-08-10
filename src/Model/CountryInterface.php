<?php

declare(strict_types=1);

namespace App\Model;

interface CountryInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getTaxPercentage(): float;

    public function getTaxNumberPattern(): string;
}