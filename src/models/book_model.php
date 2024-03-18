<?php

require_once("model.php");
require_once("dbManager.php");

class book_model extends model{

    function __construct(){
        parent::__construct();
    }

    public function getAllBooks(){
        $query = "SELECT *
                    FROM libri";
        return $_SESSION["connection"]->performQuery($query);
    }

    public function searchBookByTitle($titolo){
        $query = "SELECT *
                    FROM libri
                    WHERE titolo = '$titolo'";

        $result = $this->dbConnection->performQuery($query);
        if($result == NULL){
            return NULL;
        }
    }

    public function getParoleChiaveByBook($ID) {
        $query = "SELECT *
                    FROM paroleLibro";
    }
}