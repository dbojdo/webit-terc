<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use PHPUnit\Framework\TestCase;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\TercEntity;

class TercEntitiesDoctrineUpdaterTest extends TestCase
{
    use DoctrineInfrastructureTestTrait;

    /** @var TercEntitiesDoctrineUpdater */
    private $updater;

    protected function setUp()
    {
        $file = TercFiles::test2();
        $this->updater = new TercEntitiesDoctrineUpdater(
            $this->entityManager(),
            new TercEntityFromCsvLoader($file)
        );
    }

    /**
     * @test
     */
    public function itLoadsEntities()
    {
        $this->updateSchema();
        $this->updater->update();

        $this->assertEquals(
            22,
            count($this->entityManager()->getRepository(TercEntity::class)->findAll())
        );
    }
}
