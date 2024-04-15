<?php

require_once("model.php");

class book_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllBooks(){
        $query = "SELECT *
                    FROM libri";
        $result =  $this->query($query);
        $books = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
        return $books;
    }

    public function getBook($idLibro){
        $query = "SELECT *
                    FROM libri
                    WHERE idLibro = '$idLibro'";
        $result =  $this->query($query);
        return mysqli_fetch_assoc($result);
    }

    public function getIdByTitle($titolo){
        $query = "SELECT idLibro
                    FROM libri
                    WHERE titolo = '$titolo'";
        $result =  $this->query($query);
        return mysqli_fetch_assoc($result)["idLibro"];
    }

    public function insertBook($ISBN, $titolo, $copertina, $idCasaEditrice, $trama, $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore){
        $query = "INSERT INTO libri (ISBN, titolo, copertina, casaEditrice, trama, tipologia, dataPubblicazione, disponibilita, professore) 
                VALUES ('$ISBN', '$titolo', '$copertina', $idCasaEditrice, '$trama', $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore)";
        $result = $this->query($query);
        
        return ($result) ? true : false;
    }
}