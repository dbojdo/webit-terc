<?php

namespace Webit\Terc;

final class BoroughCollection extends TercEntityCollection
{
    protected function supportedEntityClass(): string
    {
        return Borough::class;
    }
}
