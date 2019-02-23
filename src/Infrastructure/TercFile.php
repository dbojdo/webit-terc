<?php

namespace Webit\Terc\Infrastructure;

final class TercFile
{
    /** @var string */
    private $file;

    private function __construct(string $file)
    {
        $this->file = realpath($file);
    }

    public static function sample(): TercFile
    {
        return self::create(__DIR__ . '/../Resources/TERC_Adresowy_Sample.csv');
    }

    public static function create(string $filename): TercFile
    {
        return new self($filename);
    }

    public function __toString(): string
    {
        return $this->file;
    }
}
