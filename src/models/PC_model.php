<?php
require_once ("model.php");

class PC_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getAllParoleChiave()
    {
        $query = "SELECT *
                    FROM parolechiave";
        $result = $this->query($query);
        $pc = array();
        while ($row = mysqli_fetch_array($result)) {
            $pc[] = $row;
        }
        return $pc;
    }

    function insertParola($parola)
    {
        //Controlla se la parola esiste già
        if (!$this->getIdByParola($parola)) {
            //Genere non esiste
            $query = "INSERT INTO parolechiave (parolaChiave) VALUES ('$parola')";
            $this->query($query);
            return true;
        } else {
            //Parola esiste
            return false;
        }
    }

    function multiInsertPC($PC)
    {
        foreach ($PC as &$parola) {
            $this->insertParola($parola);
        }
    }

    function getIdByParola($parola)
    {
        $query = "SELECT *
                    FROM parolechiave
                    WHERE parolaChiave = '$parola'";
        $result = $this->query($query);
        
        return ($result) ? (mysqli_fetch_assoc($result))["idParola"] : null;
    }

    public function getParolaById($id)
    {
        $query = "SELECT *
                    FROM parolechiave
                    WHERE idParolaChiave='$id'";
        $result = $this->query($query);

        return $result;
    }

    public function getParoleChiaveByLibro($idLibro)
    {
        $query = "SELECT pc.parolaChiave
                    FROM paroleChiave as pc, paroleLibro as pl
                    WHERE pc.libro='$idLibro' AND pc.idParola=pl.parola";
        $result = $this->query($query);
        $pc = array();
        while ($row = mysqli_fetch_array($result)) {
            $pc[] = $row;
        }
        return $pc;
    }
}