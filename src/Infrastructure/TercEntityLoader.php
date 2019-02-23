<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\TercEntity;

interface TercEntityLoader
{
    /**
     * @param TercEntityLoaderAdapter $adapter
     * @return TercEntity[]
     */
    public function load(TercEntityLoaderAdapter $adapter): array;
}