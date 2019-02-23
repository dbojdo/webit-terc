<?php

namespace Webit\Terc;

abstract class TercEntity
{
    /** @var string */
    protected $code;

    /** @var string */
    private $name;

    /** @var \DateTimeInterface */
    private $updatedAt;

    protected function __construct(string $code, string $name, \DateTimeInterface $updatedAt)
    {
        $this->code = (string)$code;
        $this->name = $name;
        $this->updatedAt = $updatedAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    abstract public function code();

    abstract public function description(): string;

    public function updatedAt(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->updatedAt->format('Y-m-d').' 00:00:00');
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function __sleep()
    {
        $this->updatedAt = $this->updatedAt->format('Y-m-d');
        return ['code', 'name', 'updatedAt'];
    }

    public function __wakeup()
    {
        $this->updatedAt = new \DateTimeImmutable($this->updatedAt);
    }
}
