<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Webit\Terc\LimitOffset;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;
use Webit\Terc\VoivodeshipCollection;
use Webit\Terc\VoivodeshipRepository;

final class VoivodeshipEntityRepository extends EntityRepository implements VoivodeshipRepository
{
    public function get(VoivodeshipCode $code): ?Voivodeship
    {
        return $this->find((string)$code);
    }

    public function getByName(string $name): ?Voivodeship
    {
        return $this->findOneBy(['name' => mb_strtolower($name)]);
    }

    public function getAll(): VoivodeshipCollection
    {
        return new VoivodeshipCollection($this->findAll(), LimitOffset::all());
    }
}
