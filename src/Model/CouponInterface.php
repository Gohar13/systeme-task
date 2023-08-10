<?php

declare(strict_types=1);

namespace App\Model;

interface CouponInterface
{
    public function getId(): int;

    public function getCode(): string;

    public function getSaleValue(): float;

    public function getSaleType(): string;

    public function isUsed(): bool;
}