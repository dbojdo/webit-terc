<?php

namespace Webit\Terc\Infrastructure;

use PHPUnit\Framework\TestCase;

class TercFileTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesDefaultFile()
    {
        $tercFile = TercFile::sample();
        $this->assertInstanceOf(TercFile::class, $tercFile);
    }

    /**
     * @test
     */
    public function itCreatesFileFromPathname()
    {
        $tercFile = TercFile::create(__DIR__.'/Resources/terc_test.csv');
        $this->assertInstanceOf(TercFile::class, $tercFile);
    }

    /**
     * @test
     */
    public function itCastsToString()
    {
        $tercFile = TercFile::create($pathname = __DIR__.'/Resources/terc_test.csv');
        $this->assertEquals($pathname, (string)$tercFile);
    }

    /**
     * @test
     */
    public function itResolvesRealPath()
    {
        $tercFile = TercFile::create(__DIR__ . '/Resources/terc_test_link.csv');
        $this->assertEquals(__DIR__ . '/Resources/terc_test.csv', (string)$tercFile);
    }
}