<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class DistrictTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsCodeAndTypeAndNameAndUpdatedAt()
    {
        $district = new TestDistrict(
            $code = new DistrictCode('0201'),
            $name = 'BOLesławiecki',
            $type = DistrictType::district(),
            $updatedAt = new \DateTimeImmutable('2019-01-01 00:00:00')
        );

        $this->assertEquals($code, $district->code());
        $this->assertEquals(mb_strtolower($name), $district->name());
        $this->assertEquals($type, $district->type());
        $this->assertEquals($updatedAt, $district->updatedAt());
    }

    /**
     * @test
     */
    public function itCastsToStringAsName()
    {
        $district = new TestDistrict(
            new DistrictCode('0201'),
            $name = 'BOLesławiecki',
            DistrictType::district(),
            new \DateTimeImmutable('2019-01-01 00:00:00')
        );

        $this->assertEquals(mb_strtolower($name), $district->name());
    }
}

class TestDistrict extends District
{
}