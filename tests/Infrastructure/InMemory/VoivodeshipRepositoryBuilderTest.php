<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Doctrine\Common\Cache\VoidCache;
use PHPUnit\Framework\TestCase;
use Webit\Terc\Infrastructure\Resources\TercFiles;

class VoivodeshipRepositoryBuilderTest extends TestCase
{
    /** @var VoivodeshipRepositoryBuilder */
    private $builder;

    protected function setUp()
    {
        $this->builder = VoivodeshipRepositoryBuilder::create();
    }

    /**
     * @test
     */
    public function itCreatesLazyRepositoryByDefault()
    {
        $repository = $this->builder->build();
        $this->assertInstanceOf(VoivodeshipLazyRepository::class, $repository);
    }

    /**
     * @test
     */
    public function itSetsLazyFlag()
    {
        $this->builder->setLazy(false);
        $this->assertNotInstanceOf(VoivodeshipLazyRepository::class, $this->builder->build());
    }

    /**
     * @test
     */
    public function itSetsCustomTercFile()
    {
        $this->builder->fromFile(TercFiles::test());
        $repository = $this->builder->build();
        $this->assertEquals(1, count($repository->getAll()));
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