<?php
namespace Entity;
class Ambient {
    private float $temp;
    private float $humitat;
    private float $llum;

    public function getLlum(): float
    {
        return $this->llum;
    }

    public function setLlum(float $llum): void
    {
        $this->llum = $llum;
    }

    public function getHumitat(): float
    {
        return $this->humitat;
    }

    public function setHumitat(float $humitat): void
    {
        $this->humitat = $humitat;
    }

    public function getTemp(): float
    {
        return $this->temp;
    }

    public function setTemp(float $temp): void
    {
        $this->temp = $temp;
    }

}

?>