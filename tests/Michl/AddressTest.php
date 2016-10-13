<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Address
 *
 * @uses Mihaeu\Hotshowers\City
 * @uses Mihaeu\Hotshowers\Country
 * @uses Mihaeu\Hotshowers\HouseNumber
 * @uses Mihaeu\Hotshowers\Street
 * @uses Mihaeu\Hotshowers\ZipCode
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{
    /** @var Address */
    private $address;

    public function setUp()
    {
        $this->address = new Address(
            new City('Testcity'),
            new Country('DE'),
            new ZipCode('12345'),
            new Street('Test'),
            new HouseNumber('123abc')
        );
    }

    public function testHasCity()
    {
        $this->assertEquals(new City('Testcity'), $this->address->city());
    }

    public function testHasCountry()
    {
        $this->assertEquals(new Country('DE'), $this->address->country());
    }

    public function testHasZipCode()
    {
        $this->assertEquals('12345', $this->address->zipCode());
    }

    public function testHasStreet()
    {
        $this->assertEquals(new Street('Test'), $this->address->street());
    }

    public function testHasHouseNumber()
    {
        $this->assertEquals(new HouseNumber('123abc'), $this->address->houseNumber());
    }

    public function testToString()
    {
        $this->assertEquals('Test 123abc'.PHP_EOL
            .'12345 Testcity'.PHP_EOL
            .'Germany', $this->address);
    }
}
