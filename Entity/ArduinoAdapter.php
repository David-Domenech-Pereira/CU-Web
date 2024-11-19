<?php
namespace Entity;

class ArduinoAdapter implements SensorAdapter{

    public function adapt(string $request):Ambient{
        [
            "temp" => $temp,
            "humitat" => $humitat,
            "llum" => $llum
        ] = json_decode($request, true);

        if ($temp == null || $humitat == null || $llum == null){
            throw new \Exception("Error en la petició");
        }

        $ambient = new Ambient();
        $ambient->setTemp($temp);
        $ambient->setHumitat($humitat);
        $ambient->setLlum($llum);

        return $ambient;
    }

}

?>