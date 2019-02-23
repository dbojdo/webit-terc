<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;
use Webit\Terc\Infrastructure\InfrastructureTestTrait;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercFile;
use Webit\Terc\Infrastructure\VoivodeshipRepositoryTest;
use Webit\Terc\VoivodeshipRepository;

class VoivodeshipInMemoryRepositoryTest extends VoivodeshipRepositoryTest
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

    protected function repository(): VoivodeshipRepository
    {
        $builder = VoivodeshipRepositoryBuilder::create()
            ->setLazy(false)
            ->fromFile($this->tercFile())
            ->setCache($this->cache);

        return $builder->build();
    }
}
