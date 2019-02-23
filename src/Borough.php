<?php

namespace Webit\Terc;

abstract class Borough extends TercEntity
{
    public static function fromString(string $code, string $name, string $updatedAt): Borough
    {
        return new static(new BoroughCode($code), $name, new \DateTimeImmutable($updatedAt));
    }

    public function __construct(BoroughCode $code, string $name, \DateTimeInterface $updatedAt)
    {
        parent::__construct((string)$code, $name, $updatedAt);
    }

    public function code(): BoroughCode
    {
        return new BoroughCode($this->code);
    }

    public function description(): string
    {
        return $this->code()->boroughType()->name();
    }
}
