<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Webit\Terc\BoroughRepository;
use Webit\Terc\Infrastructure\BoroughRepositoryTest;

class BoroughEntityRepositoryTest extends BoroughRepositoryTest
{
    use DoctrineInfrastructureTestTrait;

    protected function repository(): BoroughRepository
    {
        return $this->entityManager()->getRepository(Borough::class);
    }
}
