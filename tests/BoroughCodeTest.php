<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class BoroughCodeTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsFullBoroughCode()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals($code, $code->code());
    }

    /**
     * @test
     */
    public function itKeepsBoroughCode()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals('01', $code->boroughCode());
    }

    /**
     * @test
     */
    public function itKeepsBoroughType()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals(BoroughType::fromType(1), $code->boroughType());
    }

    /**
     * @test
     */
    public function itKeepsDistrictCode()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals($code, $code->code());
        $this->assertEquals(new DistrictCode('0202'), $code->districtCode());
    }

    /**
     * @test
     */
    public function itKeepsVoivodeshipCode()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals(new VoivodeshipCode('02'), $code->voivodeshipCode());
    }

    /**
     * @test
     */
    public function itCastsToString()
    {
        $code = new BoroughCode($code = '0202011');
        $this->assertEquals($code, (string)$code);
    }

    /**
     * @test
     * @dataProvider invalidCodes
     */
    public function itCannotBeConstructedWithInvalidCode(string $invalidCode)
    {
        $this->expectException(InvalidBoroughCodeException::class);
        new BoroughCode($invalidCode);
    }

    public function invalidCodes()
    {
        return [
            'empty' => [''],
            'less than 7 digits' => ['020'],
            'more than 7 digits' => ['02040322'],
        ];
    }
}