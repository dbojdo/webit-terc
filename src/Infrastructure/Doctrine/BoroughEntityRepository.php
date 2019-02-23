<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\BoroughCollection;
use Webit\Terc\BoroughRepository;
use Webit\Terc\DistrictCode;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

final class BoroughEntityRepository extends EntityRepository implements BoroughRepository
{
    public function get(BoroughCode $boroughCode): ?Borough
    {
        return $this->find((string)$boroughCode);
    }

    public function getAllOfDistrict(DistrictCode $districtCode): BoroughCollection
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where($qb->expr()->like('b.code', ':code'));
        $qb->setParameter('code', (string)$districtCode.'%');

        return new BoroughCollection($qb->getQuery()->execute(), LimitOffset::all());
    }

    public function getAllOfVoivodeship(VoivodeshipCode $voivodeshipCode, ?LimitOffset $limitOffset = null): BoroughCollection
    {
        $limitOffset = $limitOffset ?: LimitOffset::default();

        $qb = $this->createQueryBuilder('b');
        $qb->where($qb->expr()->like('b.code', ':code'));
        $qb->setParameter('code', (string)$voivodeshipCode.'%');

        $total = null;
        if ($limitOffset->isLimited()) {
            $qb->select($qb->expr()->count('b.code'));
            $total = $qb->getQuery()->getSingleScalarResult();

            $qb->select('b');
            $qb->setFirstResult($limitOffset->offset());
            $qb->setMaxResults($limitOffset->limit());

            return new BoroughCollection($qb->getQuery()->execute(), $limitOffset, $total);
        }

        return new BoroughCollection($qb->getQuery()->execute(), LimitOffset::all());
    }

    public function getByDistrictAndName(DistrictCode $districtCode, string $name): BoroughCollection
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where($qb->expr()->like('b.code', ':code'));

        $qb->andWhere($qb->expr()->eq($qb->expr()->lower('b.name'), ':name'));
        $qb->setParameter('code', (string)$districtCode.'%');
        $qb->setParameter('name', mb_strtolower($name));

        return new BoroughCollection($qb->getQuery()->execute(), LimitOffset::all());
    }

    public function getAll(?LimitOffset $limitOffset = null): BoroughCollection
    {
        $limitOffset = $limitOffset ?: LimitOffset::default();

        if ($limitOffset->isLimited()) {
            return new BoroughCollection(
                $this->findBy([], [], $limitOffset->limit(), $limitOffset->offset()),
                $limitOffset,
                $this->count([])
            );
        }

        return new BoroughCollection($this->findAll(), $limitOffset);
    }
}
