<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\BoroughCollection;
use Webit\Terc\BoroughRepository;
use Webit\Terc\DistrictCode;
use Webit\Terc\Infrastructure\InMemory\Borough as InMemoryBorough;
use Webit\Terc\Infrastructure\InvalidRepositoryArgumentException;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class BoroughInMemoryRepository implements BoroughRepository
{
    /** @var Borough[][][] */
    private $boroughs;

    /**
     * @param Borough[] $boroughs
     */
    public function __construct(array $boroughs)
    {
        $this->boroughs = [];
        foreach ($boroughs as $borough) {
            if ($borough instanceof InMemoryBorough) {
                $this->boroughs[(string)$borough->code()->voivodeshipCode()][(string)$borough->code()->districtCode()][$borough->code()->code()] = $borough;
                continue;
            }
            throw new InvalidRepositoryArgumentException(
                BoroughInMemoryRepository::class,
                Borough::class,
                $borough
            );
        }
    }

    public function get(BoroughCode $boroughCode): ?Borough
    {
        return isset(
            $this->boroughs[(string)$boroughCode->voivodeshipCode()][(string)$boroughCode->districtCode()][$boroughCode->code()]
        ) ? $this->boroughs[(string)$boroughCode->voivodeshipCode()][(string)$boroughCode->districtCode()][$boroughCode->code()]
          : null;
    }

    public function getAllOfDistrict(DistrictCode $districtCode): BoroughCollection
    {
        return isset($this->boroughs[(string)$districtCode->voivodeshipCode()][(string)$districtCode->code()]) ? new BoroughCollection($this->boroughs[(string)$districtCode->voivodeshipCode()][(string)$districtCode->code()]) : new BoroughCollection([]);
    }

    public function getAllOfVoivodeship(
        VoivodeshipCode $voivodeshipCode,
        ?LimitOffset $limitOffset = null
    ): BoroughCollection {
        $limitOffset ?: LimitOffset::default();

        $voivodeshipBoroughs = isset($this->boroughs[(string)$voivodeshipCode]) ? $this->boroughs[(string)$voivodeshipCode] : [];

        $allBoroughs = [];
        foreach ($voivodeshipBoroughs as $boroughs) {
            $allBoroughs = array_merge($allBoroughs, $boroughs);
        }

        if (!$limitOffset->isLimited()) {
            return new BoroughCollection($allBoroughs);
        }

        return new BoroughCollection(
            array_slice($allBoroughs, $limitOffset->offset(), $limitOffset->limit()),
            $limitOffset,
            count($allBoroughs)
        );
    }

    public function getByDistrictAndName(DistrictCode $districtCode, string $name): BoroughCollection
    {
        $boroughs = isset($this->boroughs[(string)$districtCode->voivodeshipCode()][(string)$districtCode->code()]) ? $this->boroughs[(string)$districtCode->voivodeshipCode()][(string)$districtCode->code()] : [];

        $name = mb_strtolower($name);
        $found = [];
        foreach ($boroughs as $borough) {
            if (mb_strtolower($borough->name() == $name)) {
                $found[] = $borough;
            }
        }

        return new BoroughCollection($found);
    }

    public function getAll(?LimitOffset $limitOffset = null): BoroughCollection
    {
        $allBoroughs = [];
        foreach ($this->boroughs as $boroughsByDistrict) {
            foreach ($boroughsByDistrict as $boroughs) {
                $allBoroughs = array_merge($allBoroughs, $boroughs);
            }
        }

        if (!$limitOffset->isLimited()) {
            return new BoroughCollection($allBoroughs);
        }

        return new BoroughCollection(
            array_slice($allBoroughs, $limitOffset->offset(), $limitOffset->limit()),
            $limitOffset,
            count($allBoroughs)
        );
    }
}