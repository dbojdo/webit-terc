<?php

namespace Webit\Terc;

final class DistrictType
{
    private const DISTRICT = [1, 'powiat'];
    private const CITY = [2, 'miasto na prawach powiatu'];
    private const CAPITAL_CITY = [3, 'miasto stołeczne, na prawach powiatu'];

    /** @var int */
    private $type;

    /** @var string */
    private $name;

    public static function district(): DistrictType
    {
        return new self(self::DISTRICT[0], self::DISTRICT[1]);
    }

    public static function city(): DistrictType
    {
        return new self(self::CITY[0], self::CITY[1]);
    }

    public static function capitalCity(): DistrictType
    {
        return new self(self::CAPITAL_CITY[0], self::CAPITAL_CITY[1]);
    }

    public static function fromType(int $type): DistrictType
    {
        switch ($type) {
            case self::DISTRICT[0]:
                return self::district();
            case self::CITY[0]:
                return self::city();
            case self::CAPITAL_CITY[0]:
                return self::capitalCity();
        }

        throw new \InvalidArgumentException(sprintf('Unsupported district type "%s"', $type));
    }

    public static function fromName(string $name): DistrictType
    {
        switch (mb_strtolower(trim($name))) {
            case self::DISTRICT[1]:
                return self::district();
            case self::CITY[1]:
                return self::city();
            case self::CAPITAL_CITY[1]:
                return self::capitalCity();
        }

        throw new \InvalidArgumentException(sprintf('Unsupported district name "%s"', $name));
    }

    private function __construct(int $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}