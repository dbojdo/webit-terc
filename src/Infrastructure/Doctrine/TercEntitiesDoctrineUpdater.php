<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Webit\Terc\Infrastructure\BoroughLoader;
use Webit\Terc\Infrastructure\DistrictLoader;
use Webit\Terc\Infrastructure\TercEntitiesUpdater;
use Webit\Terc\Infrastructure\TercEntityLoader;
use Webit\Terc\Infrastructure\VoivodeshipLoader;
use Webit\Terc\TercEntity;

final class TercEntitiesDoctrineUpdater implements TercEntitiesUpdater
{
    /** @var EntityManager */
    private $entityManager;

    /** @var TercEntityLoader */
    private $tercEntityLoader;

    public function __construct(
        EntityManager $entityManager,
        TercEntityLoader $tercEntityLoader
    ) {
        $this->entityManager = $entityManager;
        $this->tercEntityLoader = $tercEntityLoader;
    }

    public function update()
    {
        $this->clearEntityManager();

        $this->entityManager->transactional(function () {
            $this->entityManager
                ->getConnection()
                ->createQueryBuilder()
                    ->delete($this->entityManager->getClassMetadata(TercEntity::class)->getTableName())
                    ->execute();

            foreach ($this->tercEntityLoader->load(DoctrineLoaderAdapter::voivodeshipAdapter()) as $entity) {
                $this->entityManager->persist($entity);
            }

            foreach ($this->tercEntityLoader->load(DoctrineLoaderAdapter::districtAdapter()) as $entity) {
                $this->entityManager->persist($entity);
            }

            foreach ($this->tercEntityLoader->load(DoctrineLoaderAdapter::boroughAdapter()) as $entity) {
                $this->entityManager->persist($entity);
            }

            $this->entityManager->flush();
        });

        $this->clearEntityManager();
    }

    private function clearEntityManager()
    {
        $this->entityManager->clear(TercEntity::class);
    }
}
