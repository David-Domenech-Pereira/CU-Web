<?php
namespace Entity;
class Llum {
    public const NUM_LLUMS = 3;
    private int $colorR;
    private int $colorG;
    private int $colorB;
    private int $intensitat;
    private bool $teColor;
    private int $tipusLlumunositat; //Valor entre 0 i 100

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

    public function setIntensitat(float $intensitat){
        $this->intensitat=round($intensitat);
    }

    public function getTeColor(){
        return $this->teColor;
    }

    public function setTeColor(bool $teColor ){
        $this->teColor=$teColor;
    }

    public function getTipusLlumunositat(){
        return $this->tipusLlumunositat;
    }

    public function setTipusLlumunositat(int $tipusLlumunositat){
        if($tipusLlumunositat<0){
            $tipusLlumunositat=0;
        }else if($tipusLlumunositat>100){
            $tipusLlumunositat=100;
        }

        $this->tipusLlumunositat=$tipusLlumunositat;
    }
    
}

?>