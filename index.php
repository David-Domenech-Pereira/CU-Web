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
?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<div class="container m-3">
    <h1>Sistema automàtic de control de llum</h1>
    <div class="card">
        <div class="card-body">
            <form action="form.php" method="post">
                <div class="form-check form-switch">
                    <input class="form-check-input" <?php echo  $config['automatic'] == 1 ? "checked":""; ?> name="automatic" type="checkbox" role="switch" id="automatic">
                    <label class="form-check-label" for="automatic">Mode Automátic</label>
                </div>
                <label for="intensitat" class="form-label">Intensitat</label>
                <input type="range" name="intensitat" class="form-range" id="intensitat" value="<?php echo $config['intensitat'] ?>">
                <label for="calor" class="form-label">Calor</label>
                <input type="range" name="calor" class="form-range" id="calor" value="<?php echo $config['calor'] ?>">
                <label for="color" class="form-label">Color picker</label>
                <input type="color" name="color" class="form-control form-control-color" id="color" value="#563d7c"
                       title="Choose your color" value="<?php echo $config['color'] ?>">
                <input type="submit" class="btn btn-primary mt-3" value="Enviar">
            </form>
        </div>
    </div>
</div>
</body>