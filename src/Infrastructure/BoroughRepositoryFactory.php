<?php

namespace Webit\Terc\Infrastructure;

use Webit\Terc\BoroughRepository;

interface BoroughRepositoryFactory
{
    public function create(): BoroughRepository;
}