<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class City
{
    /** @var string */
    private $city;

    /**
     * @param string $city
     */
    public function __construct(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
