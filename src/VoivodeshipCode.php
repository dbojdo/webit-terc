<?php

namespace Webit\Terc;

final class VoivodeshipCode extends TercCode
{
    protected function validate()
    {
        if (preg_match('/^\d{2}$/', $this->code())) {
            return;
        }

        throw new InvalidVoivodeshipCodeException($this->code());
    }
}
