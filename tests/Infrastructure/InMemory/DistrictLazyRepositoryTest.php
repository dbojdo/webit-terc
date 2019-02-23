<?php

namespace Webit\Terc\Infrastructure\InMemory;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictCollection;
use Webit\Terc\DistrictRepository;
use Webit\Terc\DistrictType;
use Webit\Terc\Infrastructure\DistrictLoader;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

class DistrictLazyRepositoryTest extends TestCase
{
    /** @var DistrictRepository|ObjectProphecy */
    private $innerRepository;

    /** @var DistrictLazyRepository */
    private $repository;

    private $districts;

    protected function setUp()
    {
        $this->innerRepository = $this->prophesize(DistrictRepository::class);
        $this->repository = new DistrictLazyRepository(function () {
            return $this->innerRepository->reveal();
        });

        $type = DistrictType::district()->type();
        $this->districts = [
            District::fromString('0201', 'woj #1, powiat #1', $type, '2019-01-01'),
            District::fromString('0202', 'woj #1, powiat #2', $type, '2019-01-01'),
            District::fromString('0401', 'woj #2, powiat #1', $type, '2019-01-01'),
            District::fromString('0402', 'woj #2, powiat #2', $type, '2019-01-01')
        ];
    }

    /**
     * @test
     */
    public function itCreatesInnerRepositoryOfDemandAndDelegates()
    {
        $this->innerRepository->getAll(LimitOffset::all())->shouldBeCalled()->willReturn(
            $expectedDistricts = new DistrictCollection($this->districts)
        );

        $this->assertEquals(
            $expectedDistricts,
            $this->repository->getAll(LimitOffset::all())
        );


        $this->innerRepository->getAllOfVoivodeship($code = new VoivodeshipCode('04'))->shouldBeCalled()->willReturn(
            $expectedDistricts = new DistrictCollection(array_slice($this->districts, 2, 2))
        );
        $this->assertEquals(
            $expectedDistricts,
            $this->repository->getAllOfVoivodeship($code)
        );

        $this->innerRepository->get($code = new DistrictCode('0202'))->shouldBeCalled()->willReturn(
            $expectedDistrict = $this->districts[1]
        );
        $this->assertEquals($expectedDistrict, $this->repository->get($code));


        $this->innerRepository->getByVoivodeshipAndName($code = new VoivodeshipCode('04'), $name = 'woj #2, powiat #2')->shouldBeCalled()->willReturn(
            $expectedDistrict = $this->districts[3]
        );

        $this->assertEquals(
            $this->districts[3],
            $this->repository->getByVoivodeshipAndName($code, $name)
        );
    }
}
