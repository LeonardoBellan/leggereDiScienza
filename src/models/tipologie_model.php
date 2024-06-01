<?php
require_once ("model.php");

class tipologie_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getIdByTipologia($tipologia)
    {
        $query = "SELECT *
                    FROM tipologie
                    WHERE tipologia = '$tipologia'";
        $result = $this->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['idTipologia'];
        } else {
            return null;
        }
    }

    function insertTipologia($tipologia)
    {
        //Controlla se la tipologia esiste già
        if (!$this->getIdByTipologia($tipologia)) {
            //tipologia non esiste
            $tipologia = ucfirst(strtolower($tipologia));
            $query = "INSERT INTO tipologie (tipologia) VALUES ('$tipologia')";
            $this->query($query);
            return true;
        } else {
            //tipologia esiste
            return false;
        }
    }

    public function getAllTipologie()
    {
        $query = "SELECT *
                    FROM tipologie";
        $result = $this->query($query);
        $tipologie = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $tipologie[] = $row;
        }
        return $tipologie;
    }

    public function getTipologiaByLibro($idLibro)
    {
        $query = "SELECT *
                    FROM tipologie
                    WHERE idTipologia IN 
                        (SELECT tipologia FROM libri WHERE idLibro='$idLibro')";
        $result = $this->query($query);
        return mysqli_fetch_assoc($result);
    }
}