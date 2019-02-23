<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class VoivodeshipTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsCodeAndNameAndUpdatedAt()
    {
        $voivodeship = new TestVoivodeship(
            $code = new VoivodeshipCode('02'),
            $name = 'DOLNOŚLĄSKIE',
            $updatedAt = new \DateTimeImmutable('2019-01-01 00:00:00')
        );

        $this->assertEquals($code, $voivodeship->code());
        $this->assertEquals(mb_strtolower($name), $voivodeship->name());
        $this->assertEquals($updatedAt, $voivodeship->updatedAt());
    }

    /**
     * @test
     */
    public function itCastsToStringAsName()
    {
        $voivodeship = new TestVoivodeship(
            new VoivodeshipCode('02'),
            $name = 'DOLNOŚLĄSKIE',
            $updatedAt = new \DateTimeImmutable('2019-01-01 00:00:00')
        );
        $this->assertEquals(mb_strtolower($name), $voivodeship->name());
    }
}

class TestVoivodeship extends Voivodeship
{
}