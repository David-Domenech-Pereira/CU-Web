<?php

namespace ColorCalculation;

use Entity\ColorCalculation\ColorCalculationService;
use PHPUnit\Framework\TestCase;

class ColorCalculationServiceTest extends TestCase
{
    public $temp_color = [
        [28, 10, ColorCalculationService::COLOR_BLAU],
        [20, 10, ColorCalculationService::COLOR_VERD],
        [15, 10, ColorCalculationService::COLOR_LILA],
        [28, 23, ColorCalculationService::COLOR_CALOR_NIT],
        [20, 23, ColorCalculationService::COLOR_NORMAL_NIT],
        [15, 23, ColorCalculationService::COLOR_FRED_NIT]
    ];

    public function testExecute()
    {
        $service = new ColorCalculationService();
        foreach ($this->temp_color as $value) {
            $expectedColor = $value[2];
            $actual_Valor = $service->execute($value[0], $value[1]);

            $this->assertEquals($expectedColor[0], $actual_Valor->getRed());
            $this->assertEquals($expectedColor[1], $actual_Valor->getGreen());
            $this->assertEquals($expectedColor[2], $actual_Valor->getBlue());
        }
    }
}
