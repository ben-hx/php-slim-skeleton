<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\ZipCode
 */
class ZipCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testHasZipCode()
    {
        $this->assertEquals('12345', new ZipCode('12345'));
        $this->assertEquals('12345', (new ZipCode('12345'))->toString());
    }
}
