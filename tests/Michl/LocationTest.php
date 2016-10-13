<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Location
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Location */
    private $location;

    public function setUp()
    {
        $this->location = new Location(1.23456789, 9.87654321);
    }

    public function testHasLongitude()
    {
        $this->assertEquals(1.23456789, $this->location->longitude());
    }

    public function testHasLatitude()
    {
        $this->assertEquals(9.87654321, $this->location->latitude());
    }
}
