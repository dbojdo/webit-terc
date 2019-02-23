<?php

namespace Webit\Terc;

abstract class TercEntityCollection implements \Countable, \IteratorAggregate
{
    /** @var TercEntity[] */
    private $entities;

    /** @var LimitOffset */
    private $limitOffset;

    /** @var int */
    private $total;

    public function __construct(array $entities, ?LimitOffset $limitOffset = null, ?int $total = null)
    {
        $this->entities = [];
        foreach ($entities as $entity) {
            $this->entities[] = $this->checkEntity($entity);
        }

        $this->limitOffset = $limitOffset ?: LimitOffset::all();
        if ($this->limitOffset->isLimited() && $total === null) {
            throw new \InvalidArgumentException(
                sprintf('Total number of entities must be given for limit / offset "%s"', $this->limitOffset)
            );
        }

        $this->total = $total ?: count($total);
    }

    private function checkEntity($entity): TercEntity
    {
        if (is_a($entity, $this->supportedEntityClass())) {
            return $entity;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'All entities of "%s" must be instances of "%s".',
                get_class($this),
                $this->supportedEntityClass()
            )
        );
    }

    abstract protected function supportedEntityClass(): string;

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->entities);
    }

    public function limitOffset(): LimitOffset
    {
        return $this->limitOffset;
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function total(): int
    {
        return $this->total;
    }
}
