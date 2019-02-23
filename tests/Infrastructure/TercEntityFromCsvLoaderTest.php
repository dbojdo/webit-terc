<?php

namespace Webit\Terc\Infrastructure;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Webit\Terc\Borough;
use Webit\Terc\BoroughCode;
use Webit\Terc\District;
use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictType;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;

class TercEntityFromCsvLoaderTest extends TestCase
{
    /** @var TercEntityFromCsvLoader */
    private $loader;

    /** @var TercEntityLoaderAdapter|ObjectProphecy */
    private $adapter;

    protected function setUp()
    {
        $this->loader = new TercEntityFromCsvLoader(
            TercFiles::test()
        );
        $this->adapter = $this->prophesize(TercEntityLoaderAdapter::class);
    }

    /**
     * @test
     */
    public function itLoadsVoivodeships()
    {
        $this->adapter->cacheKey()->willReturn(mt_rand(0, 10000));
        $this->adapter->createDistrict(Argument::any(), Argument::any(), Argument::any(), Argument::any())->willReturn(null);
        $this->adapter->createBorough(Argument::any(), Argument::any(), Argument::any())->willReturn(null);

        $this->adapter->createVoivodeship(
            new VoivodeshipCode('02'),
            'DOLNOŚLĄSKIE',
            new \DateTimeImmutable('2019-01-01')
        )->willReturn(
            $expected = $this->prophesize(Voivodeship::class)->reveal()
        );

        $this->assertSame([$expected], $this->loader->load($this->adapter->reveal()));
    }

    /**
     * @test
     */
    public function itLoadsDistricts()
    {
        $this->adapter->cacheKey()->willReturn(mt_rand(0, 10000));
        $this->adapter->createVoivodeship(Argument::any(), Argument::any(), Argument::any())->willReturn(null);
        $this->adapter->createBorough(Argument::any(), Argument::any(), Argument::any())->willReturn(null);

        $districts = [
            ['0201', 'powiat', 'bolesławiecki', '2019-01-01'],
            ['0202', 'powiat', 'dzierżoniowski', '2019-01-01'],
            ['0203', 'powiat', 'głogowski', '2019-01-01']
        ];

        $expected = [];
        foreach ($districts as $district) {
            $expected[] = $expectedDistrict = $this->prophesize(District::class)->reveal();
            list($code, $type, $name, $date) = $district;

            $this->adapter->createDistrict(
                new DistrictCode($code),
                DistrictType::fromName($type),
                $name,
                new \DateTimeImmutable($date)
            )->willReturn(
                $expectedDistrict
            );
        }

        $this->assertSame($expected, $this->loader->load($this->adapter->reveal()));
    }

    /**
     * @test
     */
    public function itLoadsBoroughs()
    {
        $this->adapter->cacheKey()->willReturn(mt_rand(0, 10000));
        $this->adapter->createVoivodeship(Argument::any(), Argument::any(), Argument::any())->willReturn(null);
        $this->adapter->createDistrict(Argument::any(),Argument::any(), Argument::any(), Argument::any())->willReturn(null);

        $boroughs = [
            ['0201011', 'Bolesławiec', '2019-01-01'],
            ['0201022', 'Bolesławiec', '2019-01-01'],
            ['0201032', 'Gromadka', '2019-01-01'],
            ['0201044', 'Nowogrodziec', '2019-01-01'],
            ['0201045', 'Nowogrodziec', '2019-01-01'],
            ['0201052', 'Osiecznica', '2019-01-01'],
            ['0201062', 'Warta Bolesławiecka', '2019-01-01'],

            ['0202011', 'Bielawa', '2019-01-01'],
            ['0202021', 'Dzierżoniów', '2019-01-01'],
            ['0202034', 'Pieszyce', '2019-01-01'],
            ['0202035', 'Pieszyce', '2019-01-01'],
            ['0202041', 'Piława Górna', '2019-01-01'],
            ['0202052', 'Dzierżoniów', '2019-01-01'],
            ['0202062', 'Łagiewniki', '2019-01-01'],
            ['0202074', 'Niemcza', '2019-01-01'],
            ['0202075', 'Niemcza', '2019-01-01'],

            ['0203011', 'Głogów', '2019-01-01'],
            ['0203022', 'Głogów', '2019-01-01']
        ];

        $expected = [];
        foreach ($boroughs as $borough) {
            $expected[] = $expectedBorough = $this->prophesize(Borough::class)->reveal();
            list($code, $name, $date) = $borough;

            $this->adapter->createBorough(
                new BoroughCode($code),
                $name,
                new \DateTimeImmutable($date)
            )->willReturn(
                $expectedBorough
            );
        }

        $this->assertSame($expected, $this->loader->load($this->adapter->reveal()));
    }
}
