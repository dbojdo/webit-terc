<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\VoidCache;
use PHPUnit\Framework\TestCase;
use Webit\Terc\Infrastructure\InMemory\DistrictLazyRepository;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\Infrastructure\TercFile;

class DistrictRepositoryBuilderTest extends TestCase
{
    /** @var DistrictRepositoryBuilder */
    private $builder;

    protected function setUp()
    {
        $this->builder = DistrictRepositoryBuilder::create();
    }

    /**
     * @test
     */
    public function itCreatesLazyRepositoryByDefault()
    {
        $repository = $this->builder->build();
        $this->assertInstanceOf(DistrictLazyRepository::class, $repository);
    }

    /**
     * @test
     */
    public function itSetsLazyFlag()
    {
        $this->builder->setLazy(false);
        $this->assertNotInstanceOf(DistrictLazyRepository::class, $this->builder->build());
    }

    /**
     * @test
     */
    public function itSetsCustomTercFile()
    {
        $this->builder->fromFile(TercFiles::test());
        $repository = $this->builder->build();
        $this->assertEquals(3, count($repository->getAll()));
    }

    /**
     * @test
     */
    public function itSetsCacheDir()
    {
        $this->builder->setCacheDir(sys_get_temp_dir());
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function itSetsCache()
    {
        $this->builder->setCache(new VoidCache());
        $this->assertTrue(true);
    }
}