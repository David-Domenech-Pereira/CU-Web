<?php
namespace Entity;
class Llum {
    public const NUM_LLUMS = 3;
    private int $colorR;
    private int $colorG;
    private int $colorB;
    private int $intensitat;
    private bool $teColor;

    public function getcolorR(){
        return $this->colorR;
    }

    public function setcolorR(int $r){
        $this->colorR=$r;
    }

    public function getcolorG(){
        return $this->colorG;
    }

    public function setcolorG(int $g){
        $this->colorG=$g;
    }

    public function getcolorB(){
        return $this->colorB;
    }

    public function setcolorB(int $b){
        $this->colorB=$b;
    }

    public function getIntensitat(){
        return $this->intensitat;
    }

    public function setIntensitat(int $intensitat){
        $this->intensitat=$intensitat;
    }

    public function getTeColor(){
        return $this->teColor;
    }

    public function setTeColor(bool $teColor ){
        $this->teColor=$teColor;
    }

    
}

?>