<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Address
{
    /** @var City */
    private $city;

    /** @var Country */
    private $country;

    /** @var ZipCode */
    private $zipCode;

    /** @var Street */
    private $street;

    /** @var HouseNumber */
    private $houseNumber;

    /**
     * @param City        $city
     * @param Country     $country
     * @param ZipCode     $zipCode
     * @param Street      $street
     * @param HouseNumber $houseNumber
     */
    public function __construct(
        City $city,
        Country $country,
        ZipCode $zipCode,
        Street $street,
        HouseNumber $houseNumber
    ) {
        $this->city = $city;
        $this->country = $country;
        $this->zipCode = $zipCode;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return City
     */
    public function city() : City
    {
        return $this->city;
    }

    /**
     * @return Country
     */
    public function country() : Country
    {
        return $this->country;
    }

    /**
     * @return ZipCode
     */
    public function zipCode() : ZipCode
    {
        return $this->zipCode;
    }

    /**
     * @return Street
     */
    public function street() : Street
    {
        return $this->street;
    }

    /**
     * @return HouseNumber
     */
    public function houseNumber() : HouseNumber
    {
        return $this->houseNumber;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->street.' '.$this->houseNumber.PHP_EOL.
            $this->zipCode.' '.$this->city.PHP_EOL.
            $this->country;
    }
}
