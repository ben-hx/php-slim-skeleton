<?php

namespace Mihaeu\Hotshowers;

class User
{
    /** @var Name */
    private $name;

    /** @var Username */
    private $username;

    /** @var Email */
    private $email;

    /** @var Address */
    private $address;

    /** @var Password */
    private $password;

    /** @var Location */
    private $location;

    /** @var PhoneNumber */
    private $phoneNumber;

    /**
     * @param Name        $name
     * @param Username    $username
     * @param Email       $email
     * @param Address     $address
     * @param Password    $password
     * @param Location    $location
     * @param PhoneNumber $phoneNumber
     */
    public function __construct(
        Name $name,
        Username $username,
        Email $email,
        Address $address,
        Password $password,
        Location $location,
        PhoneNumber $phoneNumber
    ) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->address = $address;
        $this->password = $password;
        $this->location = $location;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return Name
     */
    public function name() : Name
    {
        return $this->name;
    }

    /**
     * @return Username
     */
    public function username() : Username
    {
        return $this->username;
    }

    /**
     * @return Email
     */
    public function email() : Email
    {
        return $this->email;
    }

    /**
     * @return Address
     */
    public function address() : Address
    {
        return $this->address;
    }

    /**
     * @return Password
     */
    public function password() : Password
    {
        return $this->password;
    }

    /**
     * @return Location
     */
    public function location() : Location
    {
        return $this->location;
    }

    /**
     * @return PhoneNumber
     */
    public function phoneNumber() : PhoneNumber
    {
        return $this->phoneNumber;
    }
}
