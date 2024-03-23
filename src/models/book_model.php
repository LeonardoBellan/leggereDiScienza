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

    /*public function searchBookByTitle($titolo){
        $query = "SELECT *
                    FROM libri
                    WHERE titolo = '$titolo'";

        $result = $this->query($query);
        if($result == NULL){
            return NULL;
        }
    }

    public function getParoleChiaveByBook($ID) {
        $query = "SELECT *
                    FROM paroleLibro";
    }*/
}