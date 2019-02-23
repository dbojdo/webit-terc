<?php

namespace Webit\Terc\Infrastructure;

final class InvalidRepositoryArgumentException extends \InvalidArgumentException
{
    public function __construct(string $repositoryClass, string $entityType, $given)
    {
        parent::__construct(
            sprintf(
                'All the arguments of "%s" must instances of "%s" but "%s" given.',
                $repositoryClass,
                $entityType,
                $this->resolveType($given)
            )
        );
    }

    private function resolveType($given)
    {
        switch ($type = gettype($given)) {
            case 'object':
                return get_class($given);
            default:
                return $type;
        }
    }
}