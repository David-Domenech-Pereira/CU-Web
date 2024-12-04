<?php
require 'vendor/autoload.php';

use Entity\Ambient;

$values = file_get_contents('config.json');
$config = json_decode($values, true);
if (!isset($config['automatic'])) {
    $config['automatic'] = 0;
}

if (!isset($config['intensitat'])) {
    $config['intensitat'] = 100;
}

if (!isset($config['calor'])) {
    $config['calor'] = 0;
}

if (!isset($config['color'])) {
    $config['color'] = '#000000';
}

$isAutomatic = $config['automatic'] == 1;

$existingData = file_get_contents('data.json');

if ($existingData) {
    $data = json_decode($existingData, true);

    $timestamps = array_column($data, 'timestamp');
    //transform timestamp to human readable format
    foreach ($timestamps as $key => $timestamp) {
        $data[$key]['timestamp'] = date('H:i', $timestamp);
    }
} else {
    $data = [];
}
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container m-3">
    <h1>Sistema automàtic de control de llum</h1>
    <div class="card">
        <div class="card-body">
            <form action="form.php" method="post">
                <div class="form-check form-switch">
                    <input class="form-check-input" <?php echo  $isAutomatic ? "checked":""; ?> name="automatic" type="checkbox" role="switch" id="automatic" value="1">
                    <label class="form-check-label" for="automatic">Mode Automátic</label>
                </div>
                <label for="intensitat" class="form-label">Intensitat</label>
                <input type="range" name="intensitat" class="form-range" id="intensitat" value="<?php echo $config['intensitat'] ?>">
                <label for="calor" class="form-label">Calor</label>
                <input type="range" name="calor" class="form-range" id="calor" value="<?php echo $config['calor'] ?>">
                <label for="color" class="form-label">Color picker</label>
                <input type="color" name="color" class="form-control form-control-color" id="color"
                       title="Choose your color" value="<?php echo $config['color'] ?>">
                <input type="submit" class="btn btn-primary mt-3" value="Enviar">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <canvas id="temperatureChart" width="200" height="100"></canvas>
        </div>
        <div class="col-md-6">
    <canvas id="humitatChart" width="200" height="100"></canvas>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
    <canvas id="llumsChart" width="200" height="100"></canvas>
        </div>
    </div>
</div>
</body>

<script>
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
        type: 'line', // tipo de gráfico (línea)
        data: {
            labels: <?php echo json_encode(array_column($data, 'timestamp')); ?>, // etiquetas (horas)
            datasets: [
                {
                label: 'Temperatura (°C)',
                data: <?php echo json_encode(array_column($data, 'temp')); ?>, // datos (temperaturas)
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    const ctx2 = document.getElementById('humitatChart').getContext('2d');
    const humitatChart = new Chart(ctx2, {
        type: 'line', // tipo de gráfico (línea)
        data: {
            labels: <?php echo json_encode(array_column($data, 'timestamp')); ?>, // etiquetas (horas)
            datasets: [
                {
                label: 'Humitat (%)',
                data: <?php echo json_encode(array_column($data, 'humitat')); ?>, // datos (temperaturas)
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    const ctx3 = document.getElementById('llumsChart').getContext('2d');
    const llumsChart = new Chart(ctx3, {
        type: 'line', // tipo de gráfico (línea)
        data: {
            labels: <?php echo json_encode(array_column($data, 'timestamp')); ?>, // etiquetas (horas)
            datasets: [
                {
                label: 'Llums (%)',
                data: <?php echo json_encode(array_column($data, 'llum')); ?>, // datos (temperaturas)
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
