<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class BoroughTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsCodeAndNameAndUpdatedAt()
    {
        $district = new TestBorough(
            $code = new BoroughCode('0201021'),
            $name = 'Bolesławiec',
            $updatedAt = new \DateTimeImmutable('2019-01-01 00:00:00')
        );

        $this->assertEquals($code, $district->code());
        $this->assertEquals($name, $district->name());
        $this->assertEquals($updatedAt, $district->updatedAt());
    }

    /**
     * @test
     */
    public function itCastsToStringAsName()
    {
        $borough = new TestBorough(
            new BoroughCode('0201011'),
            $name = 'Bolesławiec',
            new \DateTimeImmutable('2019-01-01 00:00:00')
        );

        $this->assertEquals($name, (string)$borough);
    }
}

class TestBorough extends Borough
{
}