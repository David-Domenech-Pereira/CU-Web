<?php
namespace Entity;

interface SensorAdapter {

    public function adapt(string $request):Ambient;

}

?>