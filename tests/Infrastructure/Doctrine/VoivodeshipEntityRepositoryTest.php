<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Webit\Terc\Infrastructure\VoivodeshipRepositoryTest;
use Webit\Terc\VoivodeshipRepository;

class VoivodeshipEntityRepositoryTest extends VoivodeshipRepositoryTest
{
    use DoctrineInfrastructureTestTrait;

    protected function repository(): VoivodeshipRepository
    {
        return $this->entityManager()->getRepository(Voivodeship::class);
    }
}
