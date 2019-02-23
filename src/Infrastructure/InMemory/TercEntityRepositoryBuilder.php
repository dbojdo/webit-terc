<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\VoidCache;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercEntityLoader;
use Webit\Terc\Infrastructure\TercFile;

abstract class TercEntityRepositoryBuilder
{
    /** @var TercFile */
    protected $file;

    /** @var bool */
    protected $lazy;

    /** @var Cache */
    protected $cache;

    protected function __construct()
    {
        $this->cache = new VoidCache();
        $this->lazy = true;
    }

    abstract public function build();

    public function setLazy(bool $lazy): self
    {
        $this->lazy = $lazy;
        return $this;
    }

    public function fromFile(TercFile $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function setCacheDir(string $cacheDir): self
    {
        $this->cache = new FilesystemCache($cacheDir);
        return $this;
    }

    public function setCache(Cache $cache): self
    {
        $this->cache = $cache;
        return $this;
    }

    protected function loader(): TercEntityLoader
    {
        return new TercEntityFromCsvLoader(
            $this->file ?: TercFile::sample(),
            $this->cache
        );
    }
}
