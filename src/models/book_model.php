<?php

require_once("model.php");
require_once("dbManager.php");

class book_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllBooks(){
        $query = "SELECT *
                    FROM libri";
        $result =  $this->query($query);
        $books = array();
        while ($row = mysqli_fetch_array($result)) {
            $books[] = $row;
        }
        return $books;
    }

    public function informazioniLibro($idLibro){
        $query = "SELECT *
                    FROM libri
                    WHERE idLibro = '$idLibro'";
        $result =  $this->query($query);
        return mysqli_fetch_array($result);
    }

    public function getIdByTitle($titolo){
        $query = "SELECT idLibro
                    FROM libri
                    WHERE titolo = '$titolo'";
        $result =  $this->query($query);
        return mysqli_fetch_array($result)["idLibro"];
    }
}