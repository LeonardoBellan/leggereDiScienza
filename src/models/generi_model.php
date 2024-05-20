<?php
require_once ("model.php");

class Generi_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getIdByGenere($genere)
    {
        $query = "SELECT *
                    FROM generi
                    WHERE genere = '$genere'";
        $result = $this->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['idGenere'];
        } else {
            return null;
        }
    }

    function insertGenere($genere)
    {
        //Controlla se l'utente esiste già
        if (!$this->getIdBygenere($genere)) {
            //Genere non esiste
            $genere = ucfirst(strtolower($genere));
            $query = "INSERT INTO generi (genere) VALUES ('$genere')";
            $this->query($query);
            return true;
        } else {
            //Genere esiste
            return false;
        }
    }

    function multiInsertgeneri($generi)
    {
        foreach ($generi as &$gen) {
            $this->insertGenere($gen);
        }
    }

    public function getAllGeneri()
    {
        $query = "SELECT *
                    FROM generi";
        $result = $this->query($query);
        $generi = array();
        while ($row = mysqli_fetch_array($result)) {
            $generi[] = $row;
        }
        return $generi;
    }

    public function getGeneriByLibro($idLibro)
    {
        $query = "SELECT ge.genere
                    FROM generi as ge, generiLibro as gl
                    WHERE gl.libro='$idLibro' AND ge.idGenere=gl.genere";
        $result = $this->query($query);
        $generi = array();
        while ($row = mysqli_fetch_array($result)) {
            $generi[] = $row;
        }
        return $generi;
    }
}