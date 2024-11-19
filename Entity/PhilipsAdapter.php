<?php
namespace Entity;

class PhilipsAdapter implements LightsAdapter {

    private const IP = "192.168.1.200";
    private const USERNAME = "lONyxYP1OQRWYLsBNa3sER1hl593RJSH0r9pxGmw";
    private const LLUMS_IDS = ["1", "2", "3"];
    public function write (array $llums){
        $url = "http://".self::IP."/api/".self::USERNAME."/lights/";
        $ch = curl_init();
        $i = 0;
        foreach($llums as $llum) {
            /**
             * @var Llum $llum
             */
            $urlToSend = $url.self::LLUMS_IDS[$i]."/state";
            $content = [];
            $content["on"] = true;
            $content["bri"] = $llum->getIntensitat();
            if ($llum->getTeColor()) {
                $content["xy"] = $this->convertRGBToXY($llum->getcolorR(), $llum->getcolorG(), $llum->getcolorB());
            }

            //enviem PUT
            curl_setopt($ch, CURLOPT_URL, $urlToSend);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Permitir que cURL siga redirecciones
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Desactivar la verificación del host SSL
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Desactivar la verificación del peer SSL
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // No imprimir la respuesta
            curl_exec($ch);

            $i++;
        }
    }

    public static function convertRGBToXY($red, $green, $blue)
    {
        // Normalize the values to 1
        $normalizedToOne['red'] = $red / 255;
        $normalizedToOne['green'] = $green / 255;
        $normalizedToOne['blue'] = $blue / 255;

        // Make colors more vivid
        foreach ($normalizedToOne as $key => $normalized) {
            if ($normalized > 0.04045) {
                $color[$key] = pow(($normalized + 0.055) / (1.0 + 0.055), 2.4);
            } else {
                $color[$key] = $normalized / 12.92;
            }
        }

        // Convert to XYZ using the Wide RGB D65 formula
        $xyz['x'] = $color['red'] * 0.664511 + $color['green'] * 0.154324 + $color['blue'] * 0.162028;
        $xyz['y'] = $color['red'] * 0.283881 + $color['green'] * 0.668433 + $color['blue'] * 0.047685;
        $xyz['z'] = $color['red'] * 0.000000 + $color['green'] * 0.072310 + $color['blue'] * 0.986039;

        // Calculate the x/y values
        if (array_sum($xyz) == 0) {
            $x = 0;
            $y = 0;
        } else {
            $x = $xyz['x'] / array_sum($xyz);
            $y = $xyz['y'] / array_sum($xyz);
        }

        return [
            round($x,4),
            round($y,4)
        ];
    }

}

?>