<?php
//Lògica del main
require 'vendor/autoload.php';  //comunica al php que existeixen les classes


use Entity\ArduinoAdapter;
use Entity\ColorCalculation\ColorCalculationService;
use Entity\Llum;
use Entity\PhilipsAdapter;

$body= file_get_contents('php://input'); //Recogemos el body de la petición que hemos recibido en el input
//echo $body;
////ho escrivim en un fitxer
//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//fwrite($myfile, $body);
//fclose($myfile);

$arduinoadapter = new ArduinoAdapter(); //Creamos un objeto de la clase ArduinoAdapter

$ambient = $arduinoadapter->adapt($body); //Llamamos al método parse de la clase ArduinoAdapter y le pasamos el body de la petición

$sensacioTermica=-42.379+ 2.04901523*$ambient->getTemp() + 10.14333127*$ambient->getHumitat() -
    0.2475541*$ambient->getTemp() - 6.83783*pow(10,-2)*pow($ambient->getTemp(),2) -
    5.481717*pow(10,-2)*pow($ambient->getHumitat(),2) +
    1.22874*pow(10,-2)*pow($ambient->getTemp(),2)*$ambient->getHumitat() +
    8.5282*pow(10,-4)*$ambient->getTemp()*pow($ambient->getHumitat(),2) -
    1.99*pow(10,-6)*pow($ambient->getTemp(),2)*pow($ambient->getHumitat(),2);

$hora = date('H');

$colorCalculationService = new ColorCalculationService();
$color = $colorCalculationService->execute($sensacioTermica, $hora);

$intensityToSend = 100-$ambient->getLlum();

$llumSend = [];
for ($i=0; $i < Llum::NUM_LLUMS; $i++) {
    $llumSend[$i] = new Llum();
    $llumSend[$i]->setIntensitat($intensityToSend);
    $llumSend[$i]->setTeColor($i == 2);

    if ($llumSend[$i]->getTeColor()) {
        $llumSend[$i]->setcolorR($color->getRed());
        $llumSend[$i]->setcolorG($color->getGreen());
        $llumSend[$i]->setcolorB($color->getBlue());
    }
}


$philipsadapter = new PhilipsAdapter();
$philipsadapter->write($llumSend);

echo "{\"status\": \"ok\"}";
?>
