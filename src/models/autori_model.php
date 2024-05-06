<?php
require_once("model.php");

class Autori_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getIdByName($nome,  $cognome){
        $query = "SELECT *
                    FROM autrori
                    WHERE nome = '$nome' AND cognome='$cognome'";
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row["idAutore"];
    }

    function insertAutore($nome, $cognome){
        //Controlla se l'autore esiste già
        if(!$this->getIdByName($nome, $cognome)){
            //Autore non esiste
            $query = "INSERT INTO autori (nome, cognome) VALUES ('$nome', '$cognome')";
            $this->query($query);
            return true;
        }else{
            //Autore esiste
            return false;
        }
    }

    public function getAllAutori(){
        $query = "SELECT *
                    FROM autori";
        $result =  $this->query($query);
        $autori = array();
        while ($row = mysqli_fetch_array($result)) {
            $autori[] = $row;
        }
        return $autori;
    }

    public function getAutoreById($id){
        $query = "SELECT *
                    FROM autori
                    WHERE idAutore='$id'";
        $result =  $this->query($query);
        return $result;
    }

    public function getAutoriByLibro($idLibro){
        $query = "SELECT *
                    FROM autori
                    WHERE idAutore IN 
                        (SELECT autore FROM libri WHERE idLibro='$idLibro')";
        $result =  $this->query($query);
        return $result;
    }
}