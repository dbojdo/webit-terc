<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\CacheProvider;
use Webit\Terc\Infrastructure\TercEntitiesUpdater;
use Webit\Terc\Infrastructure\TercEntityLoader;

final class TercEntitiesInMemoryUpdater implements TercEntitiesUpdater
{
    /** @var TercEntityLoader */
    private $tercEntityLoader;

    /** @var CacheProvider */
    private $cache;

    public function __construct(TercEntityLoader $tercEntityLoader, CacheProvider $cache)
    {
        $this->tercEntityLoader = $tercEntityLoader;
        $this->cache = $cache;
    }

    public function update()
    {
        $this->cache->deleteAll();

        $this->tercEntityLoader->load(InMemoryLoaderAdapter::voivodeshipAdapter());
        $this->tercEntityLoader->load(InMemoryLoaderAdapter::districtAdapter());
        $this->tercEntityLoader->load(InMemoryLoaderAdapter::boroughAdapter());
    }
}
