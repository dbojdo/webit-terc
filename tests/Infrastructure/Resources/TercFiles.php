<?php

namespace Webit\Terc\Infrastructure\Resources;

use Webit\Terc\Infrastructure\TercFile;

final class TercFiles
{
    private function __construct()
    {
    }

    public static function test(): TercFile
    {
        return TercFile::create(__DIR__.'/terc_test.csv');
    }

    public static function test2(): TercFile
    {
        return TercFile::create(__DIR__.'/terc_test_2.csv');
    }
}