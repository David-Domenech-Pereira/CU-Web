<?php

namespace Entity\ColorCalculation;

class ColorCalculationService
{
    /*
     * Referència de temperatura segons la sensació tèrmica
     * Calor: Més de 25 graus
     * Normal: Entre 17 i 25 graus
     * Fred: Menys de 17 graus
     */
    const TEMP_NORMAL_CALOR = 25;
    const TEMP_FRED_NORMAL = 17;

    const COLOR_CALOR_DIA = [0, 0, 255]; //calor - blau
    const COLOR_FRED_DIA = [140, 14, 255]; //fred - lila
    const COLOR_NORMAL_DIA = [0, 255, 0]; //normal - verd
    const COLOR_FRED_NIT = [255, 0, 0]; //fred - vermell
    const COLOR_NORMAL_NIT = [243, 94, 14]; //normal - taronja
    const COLOR_CALOR_NIT = [177, 63, 137]; //calor - rosa

    const HORA_SURT_SOL = 6;
    const HORA_POSA_SOL = 20;

    public function execute(float $sensacioTermica, int $h): ColorCalculationResponse
    {
        $horaActual = $h;
        if($horaActual >= self::HORA_SURT_SOL && $horaActual < self::HORA_POSA_SOL) {
            $color = $this->generateDayColour($sensacioTermica);
            $tipusLlumunositat = 20;
        } else {
            $color = $this->generateNightColour($sensacioTermica);
            $tipusLlumunositat = 80;
        }

        return new ColorCalculationResponse($color[0], $color[1], $color[2], $tipusLlumunositat);
    }

    private function generateDayColour(float $sensacioTermica): array
    {
        if ($sensacioTermica >= self::TEMP_NORMAL_CALOR) {
            return self::COLOR_CALOR_DIA;
        } elseif ($sensacioTermica < self::TEMP_FRED_NORMAL) {
            return self::COLOR_FRED_DIA;
        } else {
            return self::COLOR_NORMAL_DIA;
        }
    }

    private function generateNightColour(float $sensacioTermica): array
    {
        if ($sensacioTermica >= self::TEMP_NORMAL_CALOR) {
            return self::COLOR_CALOR_NIT;
        } elseif ($sensacioTermica < self::TEMP_FRED_NORMAL) {
            return self::COLOR_FRED_NIT;
        } else {
            return self::COLOR_NORMAL_NIT;
        }
    }
}