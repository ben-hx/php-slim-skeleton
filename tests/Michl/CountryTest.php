<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Country
 */
class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testHasName()
    {
        $this->assertEquals('Germany', new Country('DE'));
        $this->assertEquals('Germany', (new Country('DE'))->toString());
    }

    public function testHasIso3166Code()
    {
        $this->assertEquals('DE', (new Country('DE'))->iso3166());
    }

    public function testChecksForValidIso3166Code()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Country('XYZ');
    }
}
