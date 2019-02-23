<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictType;
use Webit\Terc\Infrastructure\TercEntityLoaderAdapter;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;

final class InMemoryLoaderAdapter implements TercEntityLoaderAdapter
{
    /** @var string */
    private $supportedClass;

    public static function voivodeshipAdapter(): TercEntityLoaderAdapter
    {
        return new self(Voivodeship::class);
    }

    public static function districtAdapter(): TercEntityLoaderAdapter
    {
        return new self(District::class);
    }

    public static function boroughAdapter(): TercEntityLoaderAdapter
    {
        return new self(Borough::class);
    }

    private function __construct(string $supportedClass)
    {
        $this->supportedClass = $supportedClass;
    }

    public function createVoivodeship(
        VoivodeshipCode $code,
        string $name,
        \DateTimeInterface $updatedAt
    ): ?Voivodeship {
        if (!$this->supports(Voivodeship::class)) {
            return null;
        }
        return new \Webit\Terc\Infrastructure\InMemory\Voivodeship($code, $name, $updatedAt);
    }

    public function createDistrict(
        DistrictCode $code,
        DistrictType $type,
        string $name,
        \DateTimeInterface $updatedAt
    ): ?District {
        if (!$this->supports(District::class)) {
            return null;
        }

        return new \Webit\Terc\Infrastructure\InMemory\District($code, $name, $type, $updatedAt);
    }

    public function createBorough(BoroughCode $code, string $name, \DateTimeInterface $updatedAt): ?Borough
    {
        if (!$this->supports(Borough::class)) {
            return null;
        }

        return new \Webit\Terc\Infrastructure\InMemory\Borough($code, $name, $updatedAt);
    }

    public function cacheKey(): string
    {
        return sha1($this->supportedClass.self::class);
    }

    private function supports(string $class)
    {
        return is_a($class, $this->supportedClass, true);
    }
}