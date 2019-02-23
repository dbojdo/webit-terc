<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\BoroughCollection;
use Webit\Terc\BoroughRepository;
use Webit\Terc\DistrictCode;
use Webit\Terc\Infrastructure\BoroughLoader;
use Webit\Terc\Infrastructure\BoroughRepositoryFactory;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class BoroughLazyRepository implements BoroughRepository
{
    /** @var BoroughRepository */
    private $repository;

    /** @var callable */
    private $initialiser;

    public function __construct(callable $initialiser)
    {
        $this->initialiser = $initialiser;
    }

    public function get(BoroughCode $boroughCode): ?Borough
    {
        return $this->repository()->get($boroughCode);
    }

    public function getAllOfDistrict(DistrictCode $districtCode): BoroughCollection
    {
        return $this->repository()->getAllOfDistrict($districtCode);
    }

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode, ?LimitOffset $limitOffset = null): BoroughCollection
    {
        return $this->repository()->getAllOfVoivodeship($voivodeshipCode, $limitOffset);
    }

    public function getByDistrictAndName(DistrictCode $districtCode, string $name): BoroughCollection
    {
        return $this->repository()->getByDistrictAndName($districtCode, $name);
    }

    public function getAll(?LimitOffset $limitOffset = null): BoroughCollection
    {
        return $this->repository()->getAll($limitOffset);
    }

    private function repository(): BoroughRepository
    {
        if (isset($this->initialiser)) {
            $this->repository = call_user_func($this->initialiser);
            unset($this->initialiser);
        }

        return $this->repository;
    }
}
