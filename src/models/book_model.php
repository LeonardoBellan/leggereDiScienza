<?php

require_once("model.php");
require_once("dbManager.php");

class book_model extends model{

    function __construct(){
        parent::__construct();
    }

    function getAllBooks(){
        $query = "SELECT *
                    FROM libri";
    }

    function searchBookByTitle($titolo){
        $query = "SELECT *
                    FROM libri
                    WHERE titolo = '$titolo'";

        $result = $_SESSION["connection"]->performQuery($query);
        if($result == NULL){
            return NULL;
        }
    }

    function getParoleChiaveByBook($ID) {
        $query = "SELECT *
                    FROM paroleLibro";
    }
}