<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class PhoneNumber
{
    /** @var string */
    private $number;

    /**
     * @param string $number
     */
    public function __construct(string $number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
