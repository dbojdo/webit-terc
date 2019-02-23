<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\DistrictRepository;

final class DistrictRepositoryBuilder extends TercEntityRepositoryBuilder
{
    public static function create(): DistrictRepositoryBuilder
    {
        return new self();
    }

    public function build(): DistrictRepository
    {
        $initialiser = function () {
            return new DistrictInMemoryRepository(
                $this->loader()->load(InMemoryLoaderAdapter::districtAdapter())
            );
        };

        if ($this->lazy) {
            return new DistrictLazyRepository($initialiser);
        }

        return $initialiser();
    }
}
