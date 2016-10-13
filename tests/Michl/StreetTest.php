<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Street
 */
class StreetTest extends \PHPUnit_Framework_TestCase
{
    public function testHasStreet()
    {
        $this->assertEquals('Test', new Street('Test'));
        $this->assertEquals('Test', (new Street('Test'))->toString());
    }
}
