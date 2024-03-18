<?php

require_once("model.php");
require_once("dbManager.php");

class book_model extends model{

    function __construct(){
        parent::__construct();
    }

    function search($titolo){
        $query = "SELECT *
                    FROM libri
                    WHERE titolo = '$titolo'";

        $result = $_SESSION["connection"]->query($query);
        if($row == NULL){
            
        }
    }
    function userExists($user){

    }
}