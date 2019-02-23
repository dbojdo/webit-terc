<?php

namespace Webit\Terc\Infrastructure;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\VoidCache;
use Webit\Terc\BoroughCode;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictType;
use Webit\Terc\TercEntity;
use Webit\Terc\VoivodeshipCode;

final class TercEntityFromCsvLoader implements TercEntityLoader
{
    /** @var TercFile */
    private $tercFile;

    /** @var Cache */
    private $cache;

    public function __construct(
        TercFile $tercFile,
        Cache $cache = null
    ) {
        $this->tercFile = $tercFile;
        $this->cache = $cache ?: new VoidCache();
    }

    public function load(TercEntityLoaderAdapter $adapter): array
    {
        $tercFilePathname = (string)realpath($this->tercFile);

        $cacheKey = md5($adapter->cacheKey().$tercFilePathname);

        if (!$this->cache->contains($cacheKey)) {
            $entities = $this->parseFile($adapter, $tercFilePathname);
            $this->cache->save($cacheKey, $entities);

            return $entities;
        }

        return $this->cache->fetch($cacheKey);
    }

    private function parseFile(TercEntityLoaderAdapter $adapter, string $tercFilePathname)
    {
        if (!is_file($tercFilePathname) || !($file = @fopen($tercFilePathname, 'r'))) {
            throw SourceFileOpeningException::forFile($tercFilePathname);
        }

        $entities = [];
        fgetcsv($file, 0, ';'); // skip header
        while ($row = fgetcsv($file, 0, ';')) {
            // WOJ;POW;GMI;RODZ;NAZWA;NAZWA_DOD;STAN_NA
            @list ($voivodeshipCode, $districtCode, $boroughCode, $type, $name, $description, $updateAt) = $row;
            if (!$voivodeshipCode) {
                continue;
            }

            $voivodeshipCode = new VoivodeshipCode($voivodeshipCode);
            $districtCode = $districtCode ? new DistrictCode($voivodeshipCode.$districtCode) : null;
            $boroughCode = $boroughCode ? new BoroughCode($districtCode.$boroughCode.$type) : null;
            $districtType = $districtCode && !$boroughCode ? DistrictType::fromName($description) : null;
            $updateAt = new \DateTimeImmutable($updateAt);

            if ($boroughCode) {
                $entities = $this->addEntity(
                    $entities,
                    $adapter->createBorough(
                        $boroughCode,
                        $name,
                        $updateAt
                    )
                );
                continue;
            }

            if ($districtCode) {
                $entities = $this->addEntity(
                    $entities,
                    $adapter->createDistrict(
                        $districtCode,
                        $districtType,
                        $name,
                        $updateAt
                    )
                );
                continue;
            }

            if ($voivodeshipCode) {
                $entities = $this->addEntity(
                    $entities,
                    $adapter->createVoivodeship(
                        $voivodeshipCode,
                        $name,
                        $updateAt
                    )
                );
                continue;
            }
        }
        @fclose($file);

        return $entities;
    }

    private function addEntity(array $entities, ?TercEntity $entity)
    {
        if (!$entity) {
            return $entities;
        }

        $entities[] = $entity;
        return $entities;
    }
}
