<?php

namespace Webit\Terc;

final class VoivodeshipCollection extends TercEntityCollection
{
    protected function supportedEntityClass(): string
    {
        return Voivodeship::class;
    }
}