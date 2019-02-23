<?php

namespace Webit\Terc\Infrastructure;

use PHPUnit\Framework\TestCase;
use Webit\Terc\BoroughCode;
use Webit\Terc\BoroughRepository;
use Webit\Terc\DistrictCode;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;

abstract class BoroughRepositoryTest extends TestCase
{
    use InfrastructureTestTrait;

    /** @var BoroughRepository */
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

    abstract protected function repository(): BoroughRepository;

    /**
     * @test
     */
    public function itGetsAllBoroughsWithLimitAndOffset()
    {
        $limit = 5;
        $expectedCodes = [
            0 => [
                new BoroughCode('0201011'),
                new BoroughCode('0201022'),
                new BoroughCode('0201032'),
                new BoroughCode('0202011'),
                new BoroughCode('0202021')
            ],
            5 => [
                new BoroughCode('0203052'),
                new BoroughCode('0203062'),
                new BoroughCode('1201011'),
                new BoroughCode('1201064'),
                new BoroughCode('1201065'),
            ],
            10 => [
                new BoroughCode('1202042'),
                new BoroughCode('1203034'),
                new BoroughCode('1203035'),
                new BoroughCode('1203044'),
            ]
        ];

        foreach ($expectedCodes as $offset => $expectedCodesOfOffset) {
            $collection = $this->repository->getAll($limitOffset = LimitOffset::create($limit, $offset));

            $this->assertTercEntityCollection($collection, $expectedCodesOfOffset, $limitOffset);
        }
    }
//
//    /**
//     * @test
//     */
//    public function itGetsAllBoroughsWithoutLimitAndOffset()
//    {
//        $expectedCodes = [
//            new BoroughCode('0201011'),
//            new BoroughCode('0201022'),
//            new BoroughCode('0201032'),
//            new BoroughCode('0202011'),
//            new BoroughCode('0202021'),
//            new BoroughCode('0203052'),
//            new BoroughCode('0203062'),
//            new BoroughCode('1201011'),
//            new BoroughCode('1201064'),
//            new BoroughCode('1201065'),
//            new BoroughCode('1202042'),
//            new BoroughCode('1203034'),
//            new BoroughCode('1203035'),
//            new BoroughCode('1203044')
//        ];
//
//        $collection = $this->repository->getAll($limitOffset = LimitOffset::all());
//
//        $this->assertTercEntityCollection($collection, $expectedCodes, $limitOffset);
//    }
//
//    /**
//     * @test
//     * @dataProvider boroughCodes
//     */
//    public function itGetDistrictByCode(BoroughCode $code, bool $found)
//    {
//        $this->assertEquals($found, (bool)$this->repository->get($code));
//    }
//
//    public function boroughCodes()
//    {
//        return [
//            'found' => [new BoroughCode('1203044'), true],
//            'not found' => [new BoroughCode('1403044'), false]
//        ];
//    }
//
//    /**
//     * @test
//     * @dataProvider boroughNames
//     */
//    public function itGetsBoroughsByDistrictAndName(DistrictCode $districtCode, string $name, array $expectedCodes)
//    {
//        $collection = $this->repository->getByDistrictAndName($districtCode, $name);
//
//        $this->assertTercEntityCollection($collection, $expectedCodes, LimitOffset::all());
//    }
//
//    public function boroughNames()
//    {
//        return [
//            'found' => [new DistrictCode('1203'), 'ChrzANów', [new BoroughCode('1203034'), new BoroughCode('1203035')]],
//            'not found' => [new DistrictCode('0201'), 'ChrzANów', []],
//        ];
//    }
//
//    /**
//     * @test
//     */
//    public function itGetsAllBoroughsOfDistrict()
//    {
//        $districtCode = new DistrictCode('0201');
//        $expectedCodes = [
//            new BoroughCode('0201011'),
//            new BoroughCode('0201022'),
//            new BoroughCode('0201032'),
//        ];
//
//        $collection = $this->repository->getAllOfDistrict($districtCode);
//        $this->assertTercEntityCollection($collection, $expectedCodes, LimitOffset::all());
//    }
//
//    /**
//     * @test
//     */
//    public function itGetsBoroughsOfVoivodeshipWithLimitAndOffset()
//    {
//        $limit = 3;
//
//        $voivodeshipCode = new VoivodeshipCode('02');
//
//        $expectedCodes = [
//            0 => [
//                new BoroughCode('0201011'),
//                new BoroughCode('0201022'),
//                new BoroughCode('0201032'),
//
//            ],
//            3 => [
//                new BoroughCode('0202011'),
//                new BoroughCode('0202021'),
//                new BoroughCode('0203052'),
//            ],
//            6 => [
//                new BoroughCode('0203062'),
//            ]
//        ];
//
//        foreach ($expectedCodes as $offset => $expectedCodesOfOffset) {
//            $collection = $this->repository->getAllOfVoivodeship($voivodeshipCode, $limitOffset = LimitOffset::create($limit, $offset));
//
//            $this->assertTercEntityCollection($collection, $expectedCodesOfOffset, $limitOffset);
//        }
//    }
//
//    /**
//     * @test
//     */
//    public function itGetsBoroughsOfVoivodeshipWithoutLimitAndOffset()
//    {
//        $voivodeshipCode = new VoivodeshipCode('02');
//
//        $expectedCodes = [
//            new BoroughCode('0201011'),
//            new BoroughCode('0201022'),
//            new BoroughCode('0201032'),
//            new BoroughCode('0202011'),
//            new BoroughCode('0202021'),
//            new BoroughCode('0203052'),
//            new BoroughCode('0203062'),
//        ];
//
//        $collection = $this->repository->getAllOfVoivodeship($voivodeshipCode, $limitOffset = LimitOffset::all());
//
//        $this->assertTercEntityCollection($collection, $expectedCodes, $limitOffset);
//    }
}