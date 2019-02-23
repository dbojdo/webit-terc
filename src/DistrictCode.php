<?php

namespace Webit\Terc;

final class DistrictCode extends TercCode
{
    public function districtCode(): string
    {
        return substr($this->code(), -2);
    }

    public function voivodeshipCode(): VoivodeshipCode
    {
        return new VoivodeshipCode(substr($this->code(), 0, 2));
    }

    protected function validate()
    {
        if (preg_match('/^\d{4}$/', $this->code())) {
            return;
        }

        throw new InvalidDistrictCodeException($this->code());
    }
}
