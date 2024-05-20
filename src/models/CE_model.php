<?php
require_once ("model.php");

class CE_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getIdByName($nome)
    {
        $query = "SELECT *
                    FROM caseEditrici
                    WHERE nome = '$nome'";
        $result = $this->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['idCasaEditrice'];
        } else {
            return null;
        }
    }

    function insertCE($nome)
    {
        //Controlla se l'utente esiste già
        if (!$this->getIdByName($nome)) {
            //CE non esiste
            $nome = ucfirst(strtolower($nome));
            $query = "INSERT INTO caseEditrici (nome) VALUES ('$nome')";
            $this->query($query);
            return true;
        } else {
            //CE esiste
            return false;
        }
    }

    public function getAllCE()
    {
        $query = "SELECT *
                    FROM caseEditrici";
        $result = $this->query($query);
        $CE = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $CE[] = $row;
        }
        return $CE;
    }

    public function getCEById($id)
    {
        $query = "SELECT *
                    FROM caseEditrici
                    WHERE idCasaEditrice='$id'";
        $result = $this->query($query);
        return $result;
    }
}