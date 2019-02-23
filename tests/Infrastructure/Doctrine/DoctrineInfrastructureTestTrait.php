<?php

namespace Webit\Terc\Infrastructure\Doctrine;

use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

use Webit\Terc\Infrastructure\Doctrine\Mapping\Mapping;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercFile;

trait DoctrineInfrastructureTestTrait
{
    /** @var EntityManager */
    private $entityManager;

    protected function entityManager(): EntityManager
    {
        if (!$this->entityManager) {
            $configuration = new Configuration();
            $configuration->setMetadataDriverImpl(Mapping::createDriver());

            $configuration->setAutoGenerateProxyClasses(AbstractProxyFactory::AUTOGENERATE_NEVER);
            $configuration->setProxyDir(sys_get_temp_dir().substr(md5(time().mt_rand(0, 100000)), 0, 6));
            $configuration->setProxyNamespace('DoctrineProxy\\');

            $this->entityManager = EntityManager::create(
                DriverManager::getConnection(['url' => 'sqlite:///:memory:']),
                $configuration
            );
        }

        return $this->entityManager;
    }

    protected function updateSchema()
    {
        $tools = new SchemaTool($this->entityManager());
        $tools->updateSchema($this->entityManager()->getMetadataFactory()->getAllMetadata());
    }

    protected function loadTercFile(?TercFile $tercFile = null)
    {
        $this->updateSchema();

        $tercFile = $tercFile ?: TercFile::create(__DIR__.'/../Resources/terc_test.csv');

        $updater = new TercEntitiesDoctrineUpdater(
            $this->entityManager(),
            new TercEntityFromCsvLoader($tercFile)
        );

        $updater->update();
    }
}
