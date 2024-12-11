<?php

namespace Entity\FilePersistence;

use mysqli;

class FilePersistenceService
{
    private function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "cu_practica";

        $conn = new mysqli($servername, $username, $password, $dbname);

        return $conn;
    }
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
        $temp = $request->getAmbient()->getTemp();
        $humitat = $request->getAmbient()->getHumitat();
        $llum = $request->getAmbient()->getLlum();
        $sensacioTermica = $request->getSensacioTermica();

        $sql = "INSERT INTO ambient (temp, humitat, llum, sensacioTermica) VALUES (?, ?, ?, ?)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dddd", $temp, $humitat, $llum, $sensacioTermica);

        $stmt->execute();
    }

    public function get()
    {
        $sql = "SELECT * FROM ambient";
        $conn = $this->connect();
        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}