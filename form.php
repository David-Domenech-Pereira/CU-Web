<?php

use Entity\Llum;
use Entity\PhilipsAdapter;

require 'vendor/autoload.php';

if (isset($_POST['automatic'])) {
    $automatic = $_POST['automatic'];
} else {
    $automatic = 0;
}
$calor = $_POST['calor'];
$intensitat = $_POST['intensitat'];
$color = $_POST['color'];



$llumSend = [];
for ($i=0; $i < Llum::NUM_LLUMS; $i++) {
    $llumSend[$i] = new Llum();
    $llumSend[$i]->setIntensitat($intensitat);

    $llumSend[$i]->setcolorR((int) $color[0]);
    $llumSend[$i]->setcolorG((int) $color[1]);
    $llumSend[$i]->setcolorB((int) $color[2]);

    $llumSend[$i]->setTipusLlumunositat($calor);
}

file_put_contents('config.json', json_encode(['automatic' => $automatic, 'color' => $color, 'intensitat' => $intensitat, 'calor' => $calor]));

$philipsadapter = new PhilipsAdapter();
$philipsadapter->write($llumSend);

//return to index
header('Location: index.php');