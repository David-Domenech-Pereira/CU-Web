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
    const TEMP_NORMAL_CALOR = 40;
    const TEMP_FRED_NORMAL = 30;
    /*
     * Referència de colors:
     *
     * Blau: (0, 0, 255)
     * Lila: (255, 0, 255)
     * Verd: (0, 255, 0)
     * Lila-Grana-Vermell-Taronja: (255, 0, 0)
     * Vermell-Taronja: (255, 128, 0)
     * Rosa: (255, 0, 128)
     */

    const COLOR_BLAU = [0, 0, 255];
    const COLOR_LILA = [255, 0, 255];
    const COLOR_VERD = [0, 255, 0];
    const COLOR_LILA_GRANA_VERMELL_TARONJA = [255, 0, 0];
    const COLOR_VERMELL_TARONJA = [255, 128, 0];
    const COLOR_ROSA = [255, 0, 128];

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
            return self::COLOR_BLAU;
        } elseif ($sensacioTermica < self::TEMP_FRED_NORMAL) {
            return self::COLOR_LILA;
        } else {
            return self::COLOR_VERD;
        }
    }

    private function generateNightColour(float $sensacioTermica): array
    {
        if ($sensacioTermica >= self::TEMP_NORMAL_CALOR) {
            return self::COLOR_LILA_GRANA_VERMELL_TARONJA;
        } elseif ($sensacioTermica < self::TEMP_FRED_NORMAL) {
            return self::COLOR_ROSA;
        } else {
            return self::COLOR_VERMELL_TARONJA;
        }
    }
}