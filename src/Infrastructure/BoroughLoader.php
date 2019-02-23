<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\Borough;

interface BoroughLoader
{
    /**
     * @return Borough[]
     */
    public function load();
}
