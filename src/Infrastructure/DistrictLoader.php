<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\District;

interface DistrictLoader
{
    /**
     * @return District[]
     */
    public function load(): array;
}
