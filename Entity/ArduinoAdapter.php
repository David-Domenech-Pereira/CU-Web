<?php
namespace Entity;

class ArduinoAdapter implements SensorAdapter{
    private const PRIVATE_KEY = 520397;
    public function adapt(string $request):Ambient{
        [
            "temp" => $temp,
            "humitat" => $humitat,
            "llum" => $llum,
            "signature" => $signature
        ] = json_decode($request, true);

        if ($temp == null || $humitat == null || $llum == null){
            throw new \Exception("Error en la petició");
        }

        $ambient = new Ambient();
        $ambient->setTemp($temp);
        $ambient->setHumitat($humitat);
        $ambient->setLlum($llum);

        if (!$this->verifySignature($ambient, $signature)){
            throw new \Exception("Error en la signatura");
        }

        return $ambient;
    }

    private function verifySignature(Ambient $ambient, string $signature){
        //temp, humitat i llum concatenades + AES = signatura
        $operacio = round($signature / (self::PRIVATE_KEY),2);
        $sum= $ambient->getTemp() + $ambient->getHumitat() + $ambient->getLlum();

        return $operacio == $sum;
    }

}

?>