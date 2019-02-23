<?php

namespace Webit\Terc;

final class DistrictCollection extends TercEntityCollection
{
    protected function supportedEntityClass(): string
    {
        return District::class;
    }
}
