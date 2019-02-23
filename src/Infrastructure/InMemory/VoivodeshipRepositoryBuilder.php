<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\VoivodeshipRepository;

final class VoivodeshipRepositoryBuilder extends TercEntityRepositoryBuilder
{
    public static function create(): self
    {
        return new self();
    }

    public function build(): VoivodeshipRepository
    {
        $initialiser = function () {
            return new VoivodeshipInMemoryRepository(
                $this->loader()->load(InMemoryLoaderAdapter::voivodeshipAdapter())
            );
        };

        if ($this->lazy) {
            return new VoivodeshipLazyRepository($initialiser);
        }

        return $initialiser();
    }
}
