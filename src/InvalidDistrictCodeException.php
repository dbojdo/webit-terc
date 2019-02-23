<?php

namespace Webit\Terc;

final class InvalidDistrictCodeException extends \InvalidArgumentException implements TercCodeValidationException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Code "%s" is not a valid district code.', $code));
    }
}