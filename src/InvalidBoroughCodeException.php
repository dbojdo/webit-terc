<?php

namespace Webit\Terc;

final class InvalidBoroughCodeException extends \InvalidArgumentException implements TercCodeValidationException
{
    public function __construct(string $code, \Throwable $previous = null)
    {
        parent::__construct(sprintf('Code "%s" is not a valid borough code.', $code), 0, $previous);
    }
}
