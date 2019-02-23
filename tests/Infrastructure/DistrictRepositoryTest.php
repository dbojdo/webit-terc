<?php

namespace Webit\Terc\Infrastructure;

use PHPUnit\Framework\TestCase;
use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictRepository;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

abstract class DistrictRepositoryTest extends TestCase
{
    use InfrastructureTestTrait;

    /** @var DistrictRepository */
    private $repository;

    protected function setUp()
    {
        $this->loadTercFile(TercFiles::test2());
        $this->repository = $this->repository();
    }

    protected function tercFile(): TercFile
    {
        return TercFiles::test2();
    }

    abstract protected function repository(): DistrictRepository;

    /**
     * @test
     */
    public function itGetsAllDistrict()
    {
        $expectedCodes = [
            new DistrictCode('0201'),
            new DistrictCode('0202'),
            new DistrictCode('0203'),
            new DistrictCode('1201'),
            new DistrictCode('1202'),
            new DistrictCode('1203')
        ];

        $collection = $this->repository->getAll($limitOffset = LimitOffset::create(10));

        $this->assertCount(count($expectedCodes), $collection);

        /** @var District $district */
        foreach ($collection as $district) {
            $this->assertContains($district->code(), $expectedCodes, '', false, false);
        }

        $this->assertEquals($limitOffset, $collection->limitOffset());
    }

    /**
     * @test
     * @dataProvider districtCodes
     */
    public function itGetDistrictByCode(DistrictCode $code, bool $found)
    {
        $this->assertEquals($found, (bool)$this->repository->get($code));
    }

    public function districtCodes()
    {
        return [
            'found' => [new DistrictCode('0201'), true],
            'not found' => [new DistrictCode('1402'), false]
        ];
    }

    /**
     * @test
     * @dataProvider districtNames
     */
    public function itGetsDistrictByVoivodeshipAndName(VoivodeshipCode $voivodeshipCode, string $name, bool $found)
    {
        $this->assertEquals($found, (bool)$this->repository->getByVoivodeshipAndName($voivodeshipCode, $name));
    }

    public function districtNames()
    {
        return [
            'found' => [new VoivodeshipCode('02'), 'dziERżoniOwsKI', true],
            'not found' => [new VoivodeshipCode('12'), 'dziERżoniOwsKI', false],
        ];
    }

    /**
     * @test
     */
    public function itGetsAllDistrictsOfVoivodeship()
    {
        $voivodeshipCode = new VoivodeshipCode('12');
        $expectedCodes = [
            new DistrictCode('1201'),
            new DistrictCode('1202'),
            new DistrictCode('1203')
        ];

        $collection = $this->repository->getAllOfVoivodeship($voivodeshipCode);

        $this->assertCount(count($expectedCodes), $collection);

        /** @var District $district */
        foreach ($collection as $district) {
            $this->assertContains($district->code(), $expectedCodes, '', false, false);
        }

        $this->assertEquals(LimitOffset::all(), $collection->limitOffset());
    }
}