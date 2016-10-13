<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\HouseNumber
 */
class HouseNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testHasHouseNumber()
    {
        $this->assertEquals('123abc', new HouseNumber('123abc'));
        $this->assertEquals('123abc', (new HouseNumber('123abc'))->toString());
    }
}
