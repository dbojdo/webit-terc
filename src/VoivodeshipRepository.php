<?php

namespace Webit\Terc;

interface VoivodeshipRepository
{
    public function get(VoivodeshipCode $code): ?Voivodeship;

    public function getByName(string $name): ?Voivodeship;

    public function getAll(): VoivodeshipCollection;
}
