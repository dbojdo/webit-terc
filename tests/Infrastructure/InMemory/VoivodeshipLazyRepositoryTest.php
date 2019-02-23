<?php

namespace Webit\Terc\Infrastructure\InMemory;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Webit\Terc\VoivodeshipCollection;
use Webit\Terc\VoivodeshipRepository;

class VoivodeshipLazyRepositoryTest extends TestCase
{
    /** @var VoivodeshipRepository|ObjectProphecy */
    private $innerRepository;

    /** @var VoivodeshipLazyRepository */
    private $repository;

    protected function setUp()
    {
        $this->innerRepository = $this->prophesize(VoivodeshipRepository::class);
        $this->repository = new VoivodeshipLazyRepository(function () {
            return $this->innerRepository->reveal();
        });
    }

    /**
     * @test
     */
    public function itUsesInnerRepository()
    {
        // getAll
        $this->innerRepository->getAll()->shouldBeCalled()->willReturn(
            $collection = new VoivodeshipCollection([])
        );
        $this->assertEquals(
            $collection,
            $this->repository->getAll()
        );

        $voivodeship = Voivodeship::fromString('02', 'woj #1', '2019-01-01');

        // getByName
        $this->innerRepository->getByName($voivodeship->name())->shouldBeCalled()->willReturn(
            $voivodeship
        );
        $this->assertEquals($voivodeship, $this->repository->getByName($voivodeship->name()));

        // get
        $this->innerRepository->get($voivodeship->code())->shouldBeCalled()->willReturn(
            $voivodeship
        );
        $this->assertEquals($voivodeship, $this->repository->get($voivodeship->code()));
    }
}