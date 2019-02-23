<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Webit\Terc\DistrictRepository;
use Webit\Terc\Infrastructure\DistrictRepositoryTest;

class DistrictEntityRepositoryTest extends DistrictRepositoryTest
{
    use DoctrineInfrastructureTestTrait;

    protected function repository(): DistrictRepository
    {
        return $this->entityManager()->getRepository(District::class);
    }
}
