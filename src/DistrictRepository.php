<?php

namespace Webit\Terc;

interface DistrictRepository
{
    public function get(DistrictCode $code): ?District;

    public function getByVoivodeshipAndName(VoivodeshipCode $voivodeshipCode, string $name): ?District;

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode): DistrictCollection;

    public function getAll(?LimitOffset $limitOffset = null): DistrictCollection;
}
