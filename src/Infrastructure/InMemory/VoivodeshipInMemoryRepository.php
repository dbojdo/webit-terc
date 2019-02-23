<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\Infrastructure\InMemory\Voivodeship as InMemoryVoivodeship;
use Webit\Terc\Infrastructure\InvalidRepositoryArgumentException;
use Webit\Terc\LimitOffset;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;
use Webit\Terc\VoivodeshipCollection;
use Webit\Terc\VoivodeshipRepository;

final class VoivodeshipInMemoryRepository implements VoivodeshipRepository
{
    /** @var Voivodeship[] */
    private $voivodeships;

    public function __construct(array $voivodeships)
    {
        $this->voivodeships = [];
        foreach ($voivodeships as $voivodeship) {
            if ($voivodeship instanceof InMemoryVoivodeship) {
                $this->voivodeships[(string)$voivodeship->code()] = $voivodeship;
                continue;
            }

            throw new InvalidRepositoryArgumentException(
                VoivodeshipInMemoryRepository::class,
                Voivodeship::class,
                $voivodeship
            );
        }
    }

    public function get(VoivodeshipCode $code): ?Voivodeship
    {
        return $this->voivodeships[(string)$code] ?? null;
    }

    public function getByName(string $name): ?Voivodeship
    {
        $name = mb_strtolower($name);
        foreach ($this->voivodeships as $voivodeship) {
            if ($voivodeship->name() == $name) {
                return $voivodeship;
            }
        }

        return null;
    }

    public function getAll(): VoivodeshipCollection
    {
        return new VoivodeshipCollection(array_values($this->voivodeships), LimitOffset::all());
    }
}
