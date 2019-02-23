<?php

namespace Webit\Terc;

final class InvalidVoivodeshipCodeException extends \InvalidArgumentException implements TercCodeValidationException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Code "%s" is not a valid voivodeship code.', $code));
    }
}