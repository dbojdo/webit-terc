<?php

namespace Webit\Terc;

interface BoroughRepository
{
    public function get(BoroughCode $boroughCode): ?Borough;

    /**
     * @param DistrictCode $districtCode
     * @return BoroughCollection
     */
    public function getAllOfDistrict(DistrictCode $districtCode): BoroughCollection;

    /**
     * @param VoivodeshipCode $voivodeshipCode
     * @param LimitOffset|null $limitOffset
     * @return BoroughCollection
     */
    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode, ?LimitOffset $limitOffset = null): BoroughCollection;

    /**
     * @param DistrictCode $districtCode
     * @param string $name
     * @return BoroughCollection
     */
    public function getByDistrictAndName(DistrictCode $districtCode, string $name): BoroughCollection;

    /**
     * @param LimitOffset|null $limitOffset
     * @return BoroughCollection
     */
    public function getAll(?LimitOffset $limitOffset = null): BoroughCollection;
}
