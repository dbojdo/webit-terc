<?php

namespace Webit\Terc;

final class BoroughCode extends TercCode
{
    protected function validate()
    {
        if (!preg_match('/^\d{7}$/', $this->code())) {
            throw new InvalidBoroughCodeException($this->code());
        }

        try {
            $this->boroughType();
        } catch (\InvalidArgumentException $e) {
            throw new InvalidBoroughCodeException($this->code(), $e);
        }
    }

    public function voivodeshipCode(): VoivodeshipCode
    {
        return new VoivodeshipCode(substr($this->code(), 0, 2));
    }

    public function districtCode(): DistrictCode
    {
        return new DistrictCode(substr($this->code(), 0, 4));
    }

    public function boroughCode(): string
    {
        return substr($this->code(), 4, 2);
    }

    public function boroughType(): BoroughType
    {
        return BoroughType::fromType((int)substr($this->code(), -1));
    }
}
