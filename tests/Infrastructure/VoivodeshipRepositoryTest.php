<?php

namespace Webit\Terc\Infrastructure;

use PHPUnit\Framework\TestCase;
use Webit\Terc\Infrastructure\Resources\TercFiles;
use Webit\Terc\LimitOffset;
use Webit\Terc\VoivodeshipCode;
use Webit\Terc\VoivodeshipRepository;

abstract class VoivodeshipRepositoryTest extends TestCase
{
    use InfrastructureTestTrait;

    /** @var VoivodeshipRepository */
    private $repository;

    protected function setUp()
    {
        $this->loadTercFile($this->tercFile());
        $this->repository = $this->repository();
    }

    protected function tercFile(): TercFile
    {
        return TercFiles::test2();
    }

    abstract protected function repository(): VoivodeshipRepository;

    /**
     * @test
     */
    public function itGetsAllVoivodeships()
    {
        $expectedCodes = [
            new VoivodeshipCode('02'),
            new VoivodeshipCode('12')
        ];

        $collection = $this->repository->getAll();

        $this->assertTercEntityCollection($collection, $expectedCodes, LimitOffset::all());
    }

    /**
     * @test
     * @dataProvider voivodeshipCodes
     */
    public function itGetVoivoeshipByCode(VoivodeshipCode $code, bool $found)
    {
        $this->assertEquals($found, (bool)$this->repository->get($code));
    }

    public function voivodeshipCodes()
    {
        return [
            'found' => [new VoivodeshipCode('12'), true],
            'not found' => [new VoivodeshipCode('08'), false]
        ];
    }

    /**
     * @test
     * @dataProvider voivodeshipNames
     */
    public function itGetsVoivodeshipByName(string $name, bool $found)
    {
        $this->assertEquals($found, (bool)$this->repository->getByName($name));
    }

    public function voivodeshipNames()
    {
        return [
            'found' => ['DolnośLĄskie', true],
            'not found' => ['mazowieckie', false]
        ];
    }
}