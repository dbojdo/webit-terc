<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\Voivodeship;

interface VoivodeshipLoader
{
    /**
     * @return Voivodeship[]
     */
    public function load(): array;
}
