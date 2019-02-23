<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictCollection;
use Webit\Terc\DistrictRepository;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class DistrictEntityRepository extends EntityRepository implements DistrictRepository
{
    public function get(DistrictCode $code): ?District
    {
        return $this->find((string)$code);
    }

    public function getByVoivodeshipAndName(VoivodeshipCode $voivodeshipCode, string $name): ?District
    {
        $qb = $this->createQueryBuilder('d');
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->like('d.code', ':code'),
                $qb->expr()->eq('d.name', ':name')
            )
        );
        $qb->setParameter('code', (string)$voivodeshipCode.'%');
        $qb->setParameter('name', mb_strtolower($name));

        $districts = $qb->getQuery()->execute();

        if (count($districts) == 1) {
            return array_shift($districts);
        }

        return null;
    }

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode): DistrictCollection
    {
        $qb = $this->createQueryBuilder('d');
        $qb->where($qb->expr()->like('d.code', ':code'));
        $qb->setParameter('code', (string)$voivodeshipCode.'%');

        return new DistrictCollection($qb->getQuery()->execute(), LimitOffset::all());
    }

    public function getAll(?LimitOffset $limitOffset = null): DistrictCollection
    {
        $limitOffset = $limitOffset ?: LimitOffset::default();
        if ($limitOffset->isLimited()) {
            return new DistrictCollection(
                $this->findBy([], [], $limitOffset->limit(), $limitOffset->offset()),
                $limitOffset,
                $this->count([])
            );
        }

        return new DistrictCollection($this->findAll(), $limitOffset);
    }
}
