<?php

namespace Entity\ThermSensation;

use Entity\Ambient;

class ThermSensationCalculationService
{
    public function execute(Ambient $ambient): float{
        $T = $ambient->getTemp();
        $HR = $ambient->getHumitat();

        $STc = -8.78469476
            + 1.61139411 * $T
            + 2.338548839 * $HR
            - 0.14611605 * $T * $HR
            - 0.012308094 * pow($T, 2)
            - 0.016424828 * pow($HR, 2)
            + 0.002211732 * pow($T, 2) * $HR
            + 0.00072546 * $T * pow($HR, 2)
            - 0.000003582 * pow($T, 2) * pow($HR, 2);

        // Devolver el valor redondeado
        return round($STc, 2);
    }
}