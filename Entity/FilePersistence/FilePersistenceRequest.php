<?php

namespace Entity\FilePersistence;

use Entity\Ambient;
use Entity\Llum;

class FilePersistenceRequest
{
    /**
     * @var Ambient $ambient Valor que hem rebut de l'ambient
     */
    private Ambient $ambient;
    /**
     * @var Llum[] $llums Valor que hem enviat a les llums
     */
    private array $llums;
    /**
     * @var float $sensacioTermica Valor de la sensació tèrmica
     */
    private float $sensacioTermica;

    public function __construct(Ambient $ambient, array $llums, float $sensacioTermica)
    {
        $this->ambient = $ambient;
        $this->llums = $llums;
        $this->sensacioTermica = $sensacioTermica;
    }

    public function getAmbient(): Ambient
    {
        return $this->ambient;
    }

    public function getLlums(): array
    {
        return $this->llums;
    }

    public function getSensacioTermica(): float
    {
        return $this->sensacioTermica;
    }
}