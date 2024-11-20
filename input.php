<?php
//Lògica del main
require 'vendor/autoload.php';  //comunica al php que existeixen les classes


use Entity\ArduinoAdapter;
use Entity\ColorCalculation\ColorCalculationService;
use Entity\Llum;
use Entity\PhilipsAdapter;
use Entity\ThermSensation\ThermSensationCalculationService;

$body= file_get_contents('php://input'); //Recogemos el body de la petición que hemos recibido en el input
//echo $body;
////ho escrivim en un fitxer
//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//fwrite($myfile, $body);
//fclose($myfile);

$arduinoadapter = new ArduinoAdapter(); //Creamos un objeto de la clase ArduinoAdapter

$ambient = $arduinoadapter->adapt($body); //Llamamos al método parse de la clase ArduinoAdapter y le pasamos el body de la petición

$thermCalculationService = new ThermSensationCalculationService();
$sensacioTermica = $thermCalculationService->execute($ambient);

$hora = "21";

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


$philipsadapter = new PhilipsAdapter();
$philipsadapter->write($llumSend);

echo "{\"status\": \"ok\"}";
?>
