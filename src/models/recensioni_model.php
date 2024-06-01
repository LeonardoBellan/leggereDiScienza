<?php
require_once("model.php");

class recensioni_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getRecensioneById($idLibro, $idProfessore){
        $query = "SELECT *
                    FROM recensioni
                    WHERE libro='$idLibro' AND professore='$idProfessore'";
        $result =  $this->query($query);
        return $result;
    }

    public function insertRecensione($idLibro, $idProfessore, $text){
        //Controlla se l'utente ha già inserito una recensione per quel libro
        if(!$this->getRecensioneById($idLibro, $idProfessore)){
            //Recensione non esiste
            $query = "INSERT INTO recensioni (libro, professore, testo) VALUES ('$idLibro', '$idProfessore', '$text')";
            $this->query($query);
            return true;
        }else{
            //Recensione esiste
            return false;
        }
    }

    public function getRecensioniByLibro($idLibro){
        $query = "SELECT *
                    FROM recensioni
                    WHERE libro='$idLibro'";
        $result = $this->query($query);
        return $result;
    }

    public function getRecensioniByprofessore($idProfessore){
        $query = "SELECT *
                    FROM recensioni
                    WHERE professore='$idProfessore'";
        $result = $this->query($query);
        return $result;
    }

    public function getAllRecensioni(){
        $query = "SELECT *
                    FROM recensioni";
        $result =  $this->query($query);
        $CE = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $CE[] = $row;
        }
        return $CE;
    }

}