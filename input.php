<?php
//Lògica del main
require 'vendor/autoload.php';  //comunica al php que existeixen les classes


use Entity\ArduinoAdapter;
use Entity\ColorCalculation\ColorCalculationService;
use Entity\FilePersistence\FilePersistenceRequest;
use Entity\FilePersistence\FilePersistenceService;
use Entity\Llum;
use Entity\PhilipsAdapter;
use Entity\ThermSensation\ThermSensationCalculationService;

//llegim config.json
//si existeix
if (!file_exists('config.json')) {
    $config = [
        "automatic" => 1
    ];

    file_put_contents('config.json', json_encode($config));
}

$error = "";

$body= file_get_contents('php://input'); //Recogemos el body de la petición que hemos recibido en el input

$arduinoadapter = new ArduinoAdapter(); //Creamos un objeto de la clase ArduinoAdapter

$ambient = $arduinoadapter->adapt($body); //Llamamos al método parse de la clase ArduinoAdapter y le pasamos el body de la petición

if ($ambient->getTemp() > 15) {
    $thermCalculationService = new ThermSensationCalculationService();
    $sensacioTermica = $thermCalculationService->execute($ambient);
}else{
    $sensacioTermica = $ambient->getTemp();
}

$hora = 22;

$colorCalculationService = new ColorCalculationService();
$color = $colorCalculationService->execute($sensacioTermica, $hora);

$intensityToSend = 100-$ambient->getLlum();

$llumSend = [];
for ($i=0; $i < Llum::NUM_LLUMS; $i++) {
    $llumSend[$i] = new Llum();
    $llumSend[$i]->setIntensitat($intensityToSend);

    $llumSend[$i]->setcolorR($color->getRed());
    $llumSend[$i]->setcolorG($color->getGreen());
    $llumSend[$i]->setcolorB($color->getBlue());

    $llumSend[$i]->setTipusLlumunositat($color->getTipusLlumunositat());
}

$filePersistenceService = new FilePersistenceService();
$filePersistenceRequest = new FilePersistenceRequest($ambient, $llumSend, $sensacioTermica);
$filePersistenceService->persist($filePersistenceRequest);

$config = json_decode(file_get_contents('config.json'), true);
$automatic = $config['automatic'];
if ($automatic == 0) {
    echo "{\"status\": \"ok\"}";
    return;
}

try{
    $philipsadapter = new PhilipsAdapter();
    $philipsadapter->write($llumSend);
}catch(Exception $e){
    $error = $e->getMessage();
}

if ($error != ""){
    echo "{\"status\": \"error\", \"message\": \"$error\"}";
    return;
}
echo "{\"status\": \"ok\"}";
?>
