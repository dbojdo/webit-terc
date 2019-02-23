<?php

namespace Webit\Terc;

final class LimitOffset
{
    private const DEFAULT_LIMIT = 100;
    private const ALL = -1;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    public static function default(): LimitOffset
    {
        return new self(self::DEFAULT_LIMIT, 0);
    }

    public static function all(): LimitOffset
    {
        return new self(self::ALL, 0);
    }

    public static function create(int $limit, int $offset = 0)
    {
        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must not be less than 1.');
        }

        if ($offset < 0) {
            throw new \InvalidArgumentException('Offset must not be less than 1.');
        }

        return new self($limit, $offset);
    }

    private function __construct(int $limit, int $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function next(): ?LimitOffset
    {
        if (!$this->isLimited()) {
            return null;
        }

        return new self($this->limit, $this->offset + $this->limit);
    }

    public function isLimited(): bool
    {
        return $this->limit != self::ALL;
    }

    public function isLast(int $total): bool
    {
        if (!$this->isLimited()) {
            return true;
        }

        return $this->offset + $this->limit >= $total;
    }

    public function __toString(): string
    {
        return sprintf('%s,%s', $this->limit, $this->offset);
    }
}
