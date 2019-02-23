<?php

namespace Webit\Terc\Infrastructure\Doctrine\Mapping;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator;
use Doctrine\ORM\Mapping\Driver\XmlDriver;

final class Mapping
{
    private function __construct()
    {
    }

    public static function createDriver(): MappingDriver
    {
        return new XmlDriver(
            new SymfonyFileLocator(
                self::namespaces(),
                self::fileExtension()
            )
        );
    }

    public static function namespaces(): array
    {
        return [
            __DIR__ => 'Webit\Terc',
        ];
    }

    public static function fileExtension(): string
    {
        return '.orm.xml';
    }

}