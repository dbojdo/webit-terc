<?php

namespace Webit\Terc;

abstract class Voivodeship extends TercEntity
{
    public static function fromString(string $code, string $name, string $updatedAt): Voivodeship
    {
        return new static(new VoivodeshipCode($code), $name, new \DateTimeImmutable($updatedAt));
    }

    public function __construct(VoivodeshipCode $code, string $name, \DateTimeInterface $updatedAt)
    {
        parent::__construct((string)$code, mb_strtolower($name), $updatedAt);
    }

    public function code(): VoivodeshipCode
    {
        return new VoivodeshipCode($this->code);
    }

    public function description(): string
    {
        return 'województwo';
    }
}
