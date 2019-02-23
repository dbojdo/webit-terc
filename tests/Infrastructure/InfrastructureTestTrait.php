<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\LimitOffset;
use Webit\Terc\TercEntity;
use Webit\Terc\TercEntityCollection;

trait InfrastructureTestTrait
{
    protected function assertTercEntityCollection(TercEntityCollection $collection, array $expectedCodes, LimitOffset $expectedLimitOffset)
    {
        $this->assertCount(count($expectedCodes), $collection);

        /** @var TercEntity $tercEntity */
        foreach ($collection as $tercEntity) {
            $this->assertContains($tercEntity->code(), $expectedCodes, '', false, false);
        }

        $this->assertEquals($expectedLimitOffset, $collection->limitOffset());
    }

    abstract protected function loadTercFile(?TercFile $tercFile = null);
}
