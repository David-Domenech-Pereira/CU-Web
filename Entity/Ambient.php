<?php
namespace Entity;
class Ambient {
    private $temp;
    private $humitat;

    public function getTemp(){
        return $this->temp;
    }

    public function setTemp( float $temp){
        $this->temp=$temp;
    }

    public function getHumitat(){
        return $this->humitat;
    }

    public function setHumitat(float $hum){
        $this->humitat=$hum;
    }
}

?>