<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictCollection;
use Webit\Terc\DistrictRepository;
use Webit\Terc\Infrastructure\InMemory\District as InMemoryDistrict;
use Webit\Terc\Infrastructure\InvalidRepositoryArgumentException;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class DistrictInMemoryRepository implements DistrictRepository
{
    /** @var District[][] */
    private $districts;

    /**
     * @param District[] $districts
     */
    public function __construct(array $districts)
    {
        $this->districts = [];
        foreach ($districts as $district) {
            if ($district instanceof InMemoryDistrict) {
                $this->districts[(string)$district->code()->voivodeshipCode()][(string)$district->code()] = $district;
                continue;
            }
            throw new InvalidRepositoryArgumentException(
                DistrictInMemoryRepository::class,
                District::class,
                $district
            );
        }
    }

    public function get(DistrictCode $code): ?District
    {
        return $this->districts[(string)$code->voivodeshipCode()][(string)$code] ?? null;
    }

    public function getByVoivodeshipAndName(VoivodeshipCode $voivodeshipCode, string $name): ?District
    {
        $name = mb_strtolower($name);
        foreach ($this->districts[(string)$voivodeshipCode] ?? [] as $district) {
            if ($name == $district->name()) {
                return $district;
            }
        }

        return null;
    }

    public function getAll(?LimitOffset $limitOffset = null): DistrictCollection
    {
        $limitOffset = $limitOffset ?: LimitOffset::default();

        $allDistricts = [];
        foreach ($this->districts as $districts) {
            $allDistricts = array_merge($allDistricts, $districts);
        }

        if (!$limitOffset->isLimited()) {
            return new DistrictCollection($allDistricts);
        }

        return new DistrictCollection(
            array_slice($allDistricts, $limitOffset->offset(), $limitOffset->limit()),
            $limitOffset,
            count($allDistricts)
        );
    }

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode): DistrictCollection
    {
        $districts = $this->districts[(string)$voivodeshipCode] ?? [];
        return new DistrictCollection(array_values($districts), LimitOffset::all());
    }
}
