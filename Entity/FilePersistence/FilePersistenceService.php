<?php

namespace Entity\FilePersistence;

class FilePersistenceService
{
    /**
     * Lògica per persistir les dades en un fitxer.
     *
     * Llegeix el fitxer data.json, afegeix les dades rebudes i torna a escriure el fitxer.
     *
     * @param FilePersistenceRequest $request Dades a persistir
     * @return void
     */
    public function persist(FilePersistenceRequest $request)
    {
        if (!file_exists("data.json")) {
            file_put_contents("data.json", "[]");
        }

        $actualContent = file_get_contents("data.json");

        $data = $this->jsonParser($request);

        $actualContent = json_decode($actualContent, true);

        //només ens quedem amb les 100 últimes
        $actualContent  = array_slice($actualContent, -100);

        $actualContent[] = $data;

        file_put_contents("data.json", json_encode($actualContent));
    }

    /**
     * Transforma les dades rebudes en un array associatiu per a posar en un json.
     *
     * @param FilePersistenceRequest $request Dades a transformar
     * @return array
     */
    private function jsonParser(FilePersistenceRequest $request): array
    {
        $data = [];
        $data["temp"] = $request->getAmbient()->getTemp();
        $data["humitat"] = $request->getAmbient()->getHumitat();
        $data["llum"] = $request->getAmbient()->getLlum();

        $llums = $request->getLlums();
        $data["llums"] = [];
        foreach ($llums as $llum) {
            $data["llums"][] = [
                "intensitat" => $llum->getIntensitat(),
                "colorR" => $llum->getcolorR(),
                "colorG" => $llum->getcolorG(),
                "colorB" => $llum->getcolorB(),
                "tipusLlumunositat" => $llum->getTipusLlumunositat()
            ];
        }

        $data["sensacioTermica"] = $request->getSensacioTermica();

        $data["timestamp"] = time();

        return $data;
    }
}