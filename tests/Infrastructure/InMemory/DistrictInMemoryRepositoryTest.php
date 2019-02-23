<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;
use Webit\Terc\DistrictRepository;
use Webit\Terc\Infrastructure\DistrictRepositoryTest;
use Webit\Terc\Infrastructure\InfrastructureTestTrait;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercFile;

class DistrictInMemoryRepositoryTest extends DistrictRepositoryTest
{
    use InfrastructureTestTrait;

    /** @var CacheProvider */
    private $cache;

    protected function setUp()
    {
        $this->cache = new ArrayCache();
        parent::setUp();
    }

    protected function loadTercFile(?TercFile $tercFile = null)
    {
        $updater = new TercEntitiesInMemoryUpdater(
            new TercEntityFromCsvLoader($tercFile ?: $this->tercFile(), $this->cache),
            $this->cache
        );

        $updater->update();
    }

    protected function repository(): DistrictRepository
    {
        $builder = DistrictRepositoryBuilder::create()
            ->setLazy(false)
            ->fromFile($this->tercFile())
            ->setCache($this->cache);

        return $builder->build();
    }
}
