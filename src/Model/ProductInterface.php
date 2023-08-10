<?php

declare(strict_types=1);

namespace App\Model;

interface ProductInterface
{
    public function getId(): int;

    public function getPrice(): float;

    public function getName(): string;
}