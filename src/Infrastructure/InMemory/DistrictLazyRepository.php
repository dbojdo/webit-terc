<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictCollection;
use Webit\Terc\DistrictRepository;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class DistrictLazyRepository implements DistrictRepository
{
    /** @var DistrictRepository */
    private $repository;

    /** @var callable */
    private $initialiser;

    public function __construct(callable $initialiser)
    {
        $this->initialiser = $initialiser;
    }

    public function get(DistrictCode $code): ?District
    {
        return $this->repository()->get($code);
    }

    public function getByVoivodeshipAndName(VoivodeshipCode $voivodeshipCode, string $name): ?District
    {
        return $this->repository()->getByVoivodeshipAndName($voivodeshipCode, $name);
    }

    public function getAll(?LimitOffset $limitOffset = null): DistrictCollection
    {
        return $this->repository()->getAll($limitOffset);
    }

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode): DistrictCollection
    {
        return $this->repository->getAllOfVoivodeship($voivodeshipCode);
    }

    private function repository(): DistrictRepository
    {
        if (isset($this->initialiser)) {
            $this->repository = call_user_func($this->initialiser);
            unset($this->initialiser);
        }

        return $this->repository;
    }
}
