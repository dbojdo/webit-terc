<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class DistrictCodeTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsFullDistrictCode()
    {
        $code = new DistrictCode($code = '0202');
        $this->assertEquals($code, $code->code());
    }

    /**
     * @test
     */
    public function itKeepsDistrictCode()
    {
        $code = new DistrictCode($code = '0204');
        $this->assertEquals('04', $code->districtCode());
    }

    /**
     * @test
     */
    public function itKeepsVoivodeshipCode()
    {
        $code = new DistrictCode($code = '0204');
        $this->assertEquals(new VoivodeshipCode('02'), $code->voivodeshipCode());
    }

    /**
     * @test
     */
    public function itCastsToString()
    {
        $code = new DistrictCode($code = '0204');
        $this->assertEquals($code, (string)$code);
    }

    /**
     * @test
     * @dataProvider invalidCodes
     */
    public function itCannotBeConstructedWithInvalidCode(string $invalidCode)
    {
        $this->expectException(InvalidDistrictCodeException::class);
        new DistrictCode($invalidCode);
    }

    public function invalidCodes()
    {
        return [
            'empty' => [''],
            'less than 4 digits' => ['020'],
            'more than 4 digits' => ['020402'],
        ];
    }
}
