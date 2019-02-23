<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\Infrastructure\VoivodeshipLoader;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;
use Webit\Terc\VoivodeshipCollection;
use Webit\Terc\VoivodeshipRepository;

final class VoivodeshipLazyRepository implements VoivodeshipRepository
{
    /** @var VoivodeshipRepository */
    private $repository;

    /** @var VoivodeshipLoader */
    private $initialiser;

    public function __construct(callable $initialiser)
    {
        $this->initialiser = $initialiser;
    }

    public function get(VoivodeshipCode $code): ?Voivodeship
    {
        return $this->repository()->get($code);
    }

    public function getByName(string $name): ?Voivodeship
    {
        return $this->repository()->getByName($name);
    }

    public function getAll(): VoivodeshipCollection
    {
        return $this->repository()->getAll();
    }

    private function repository(): VoivodeshipRepository
    {
        if (isset($this->initialiser)) {
            $this->repository = call_user_func($this->initialiser);
            unset($this->initialiser);
        }

        return $this->repository;
    }
}
