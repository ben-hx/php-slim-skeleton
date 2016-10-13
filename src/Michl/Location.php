<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Location
{
    /** @var float */
    private $longitude;

    /** @var float */
    private $latitude;

    /**
     * Location constructor.
     *
     * @param float $longitude
     * @param float $latitude
     */
    public function __construct(float $longitude, float $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function longitude() : float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function latitude() : float
    {
        return $this->latitude;
    }
}
