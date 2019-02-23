<?php

namespace Webit\Terc;

final class BoroughType
{
    private const URBAN = [1, 'gmina miejska'];
    private const RURAL = [2, 'gmina wiejska'];
    private const URBAN_RURAL = [3, 'gmina miejsko-wiejska'];
    private const CITY_IN_URBAN_RURAL = [4, 'miasto w gminie miejsko-wiejskiej'];
    private const RURAL_IN_URBAN_RURAL = [5, 'obszar wiejski w gminie miejsko-wiejskiej'];
    private const BOROUGH_OF_WARSAW = [8, 'dzielnica w m.st. Warszawa'];
    private const DELEGACY = [9, 'delegatura'];

    /** @var int */
    private $type;

    /** @var string */
    private $name;

    public static function urban(): BoroughType
    {
        return new self(self::URBAN[0], self::URBAN[1]);
    }

    public static function countryside(): BoroughType
    {
        return new self(self::RURAL[0], self::RURAL[1]);
    }

    public static function urbanRural(): BoroughType
    {
        return new self(self::URBAN_RURAL[0], self::URBAN_RURAL[1]);
    }

    public static function cityInUrbanRural(): BoroughType
    {
        return new self(self::CITY_IN_URBAN_RURAL[0], self::CITY_IN_URBAN_RURAL[1]);
    }

    public static function ruralInUrbanCountryside(): BoroughType
    {
        return new self(self::RURAL_IN_URBAN_RURAL[0], self::RURAL_IN_URBAN_RURAL[1]);
    }

    public static function boroughOfWarsaw(): BoroughType
    {
        return new self(self::BOROUGH_OF_WARSAW[0], self::BOROUGH_OF_WARSAW[1]);
    }

    public static function delegacy(): BoroughType
    {
        return new self(self::DELEGACY[0], self::DELEGACY[1]);
    }

    private function __construct(int $type)
    {
        $this->type = $type;
    }

    public static function fromType(int $type)
    {
        switch ($type) {
            case self::URBAN[0]:
                return self::urban();
            case self::RURAL[0]:
                return self::countryside();
            case self::URBAN_RURAL[0]:
                return self::urbanRural();
            case self::CITY_IN_URBAN_RURAL[0]:
                return self::cityInUrbanRural();
            case self::RURAL_IN_URBAN_RURAL[0]:
                return self::ruralInUrbanCountryside();
            case self::BOROUGH_OF_WARSAW[0]:
                return self::boroughOfWarsaw();
            case self::DELEGACY[0]:
                return self::delegacy();
        }

        throw new \InvalidArgumentException(sprintf('Unknown borough type "%s".', $type));
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
