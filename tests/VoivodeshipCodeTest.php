<?php

namespace Webit\Terc;

use PHPUnit\Framework\TestCase;

class VoivodeshipCodeTest extends TestCase
{
    /**
     * @test
     */
    public function itKeepsVoivodeshipCode()
    {
        $code = new VoivodeshipCode($code = '02');
        $this->assertEquals($code, $code->code());
    }

    /**
     * @test
     */
    public function itCastsToString()
    {
        $code = new VoivodeshipCode($code = '02');
        $this->assertEquals($code, (string)$code);
    }

    /**
     * @test
     * @dataProvider invalidCodes
     */
    public function itCannotBeConstructedWithInvalidCode(string $invalidCode)
    {
        $this->expectException(InvalidVoivodeshipCodeException::class);
        new VoivodeshipCode($invalidCode);
    }

    public function invalidCodes()
    {
        return [
            'empty' => [''],
            'less than 2 digits' => ['2'],
            'more than 2 digits' => ['020'],
        ];
    }
}
