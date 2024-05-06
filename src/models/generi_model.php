<?php
require_once("model.php");

class Generi_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getIdByGenere($genere){
        $query = "SELECT *
                    FROM generi
                    WHERE genere = '$genere'";
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row["idGenere"];
    }

    function insertGenere($genere){
        //Controlla se l'utente esiste già
        if(!$this->getIdBygenere($genere)){
            //Genere non esiste
            $query = "INSERT INTO generi (genere) VALUES ('$genere')";
            $this->query($query);
            return true;
        }else{
            //Genere esiste
            return false;
        }
    }

    public function getAllGeneri(){
        $query = "SELECT *
                    FROM generi";
        $result =  $this->query($query);
        $generi = array();
        while ($row = mysqli_fetch_array($result)) {
            $generi[] = $row;
        }
        return $generi;
    }

    public function getGeneriByLibro($idLibro){
        $query = "SELECT ge.genere
                    FROM generi as ge, generiLibro as gl
                    WHERE gl.libro='$idLibro' AND ge.idGenere=gl.genere";
        $result =  $this->query($query);
        $generi = array();
        while ($row = mysqli_fetch_array($result)) {
            $generi[] = $row;
        }
        return $generi;
    }
}