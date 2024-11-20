<?php

namespace Entity\ColorCalculation;

class ColorCalculationResponse
{
    private int $red;
    private int $green;
    private int $blue;
    private int $tipusLlumunositat;

    public function __construct(int $red, int $green, int $blue, int $tipusLlumunositat)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->tipusLlumunositat = $tipusLlumunositat;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function getTipusLlumunositat(): int
    {
        return $this->tipusLlumunositat;
    }
}