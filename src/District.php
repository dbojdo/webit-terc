<?php

namespace Webit\Terc;

abstract class District extends TercEntity
{
    /** @var int */
    private $type;

    public static function fromString(string $code, string $name, int $type, string $updatedAt): District
    {
        return new static(new DistrictCode($code), $name, DistrictType::fromType($type), new \DateTimeImmutable($updatedAt));
    }

    public function __construct(DistrictCode $code, string $name, DistrictType $type, \DateTimeInterface $updatedAt)
    {
        parent::__construct($code, mb_strtolower($name), $updatedAt);
        $this->type = $type->type();
    }

    public function code(): DistrictCode
    {
        return new DistrictCode($this->code);
    }

    public function description(): string
    {
        return (string)$this->type;
    }

    public function type(): DistrictType
    {
        return DistrictType::fromType($this->type);
    }
}
