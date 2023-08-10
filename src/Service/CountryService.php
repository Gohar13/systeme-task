<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\InvalidTaxNumberException;
use App\Model\CountryInterface;
use App\Repository\CountryRepository;

class CountryService
{
    public function __construct(
        protected CountryRepository  $countryRepository
    ){}

    /**
     * @throws InvalidTaxNumberException
     */
    public function getCountryByTaxNumber(string $taxNumber): CountryInterface
    {
        $countries = $this->countryRepository->findAll();

        foreach ($countries as $country) {
            if (preg_match($country->getTaxNumberPattern(), $taxNumber)) {
                return $country;
            }
        }

        throw new InvalidTaxNumberException('Invalid Tax Number');
    }

}
