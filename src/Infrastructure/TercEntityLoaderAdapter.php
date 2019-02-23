<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictType;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;

interface TercEntityLoaderAdapter
{
    public function createVoivodeship(VoivodeshipCode $code, string $name, \DateTimeInterface $updatedAt): ?Voivodeship;

    public function createDistrict(DistrictCode $code, DistrictType $type, string $name, \DateTimeInterface $updatedAt): ?District;

    public function createBorough(BoroughCode $code, string $name, \DateTimeInterface $updatedAt): ?Borough;

    public function cacheKey(): string;
}
