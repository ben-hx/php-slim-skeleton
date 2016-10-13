<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Name
{
    /** @var FirstName */
    private $firstName;

    /** @var LastName */
    private $lastName;

    /**
     * @param FirstName $firstName
     * @param LastName  $lastName
     */
    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return FirstName
     */
    public function firstName() : FirstName
    {
        return $this->firstName;
    }

    /**
     * @return LastName
     */
    public function lastName() : LastName
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->firstName.' '.$this->lastName;
    }
}
