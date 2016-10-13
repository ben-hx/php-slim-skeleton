<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\City
 */
class CityTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCity()
    {
        $city = new City('Test');
        $this->assertEquals('Test', $city);
        $this->assertEquals('Test', $city->toString());
    }
}
