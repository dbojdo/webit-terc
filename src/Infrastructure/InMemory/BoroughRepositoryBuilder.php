<?php

namespace Webit\Terc\Infrastructure\InMemory;

use Webit\Terc\BoroughRepository;

final class BoroughRepositoryBuilder extends TercEntityRepositoryBuilder
{
    public static function create(): self
    {
        return new self();
    }

    public function build(): BoroughRepository
    {
        $initialiser = function () {
            return new BoroughInMemoryRepository(
                $this->loader()->load(InMemoryLoaderAdapter::boroughAdapter())
            );
        };

        if ($this->lazy) {
            return new BoroughLazyRepository($initialiser);
        }

        return $initialiser();
    }
}