<?php

require_once("model.php");
require_once("dbManager.php");

class account_model extends model{

    function __construct($DBuser){
        parent::__construct($DBuser);
    }

    function login($username, $password){
        $query = "SELECT * 
                    FROM account
                    WHERE username = '$username'
                    AND password = md5('$password')";

        //$row = $this->query($query);
        //return ($row != NULL) ? true : false;
        return true;
    }
    /*function register($username, $password){
        $query = "INSERT INTO account"
    }*/
}