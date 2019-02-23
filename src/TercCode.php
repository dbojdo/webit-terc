<?php

namespace Webit\Terc;

abstract class TercCode
{
    /** @var string */
    private $code;

    public function __construct(string $code)
    {
        $this->code = trim($code);
        $this->validate();
    }

    /**
     * @throws TercCodeValidationException
     */
    abstract protected function validate();

    public function code(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->code();
    }
}