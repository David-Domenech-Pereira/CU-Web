<?php

use Entity\FilePersistence\FilePersistenceService;

require 'vendor/autoload.php';

//Aquí ens arriba una request, on a la URL hi ha el tipus de gràfic que volem mostrar, que en realitat serà el nom de la columna

$filePersistenceService = new FilePersistenceService();

$data = $filePersistenceService->get();

$jsonData = [];

//1- posem timestamp
$jsonData['timestamp'] = array_column($data, 'timestamp');
$jsonData['data'] = array_column($data, $_GET['chart']);

echo json_encode($jsonData);