<?php

namespace ThermSensation;

use Entity\Ambient;
use Entity\ThermSensation\ThermSensationCalculationService;
use PHPUnit\Framework\TestCase;

class ThermSensationCalculationServiceTest extends TestCase
{

    private $VALUES = [
        [30, 40, 30],
        [30, 70, 35],
        [25, 60, 26],
        [20, 80, 21],
        [35, 50, 41],
        [25, 90, 26]
    ];

    public function testExecute()
    {
        $service = new ThermSensationCalculationService();
        foreach ($this->VALUES as $value) {
            $ambient = new Ambient();
            $ambient->setTemp($value[0]);
            $ambient->setHumitat($value[1]);
            $this->assertEquals(round($value[2]), round($service->execute($ambient)));
        }
    }
}
