<?php

require_once("model.php");
require_once("dbManager.php");

class account_model extends model{

    function __construct($DBuser){
        parent::__construct($DBuser);
    }

    public function login($username, $password){
        $query = "SELECT * 
                    FROM account
                    WHERE username = '$username'
                    AND password = md5('$password')";

        //$result = $this->query($query);
        //return ($result != NULL) ? true : false;
        return true;
    }
    /*
    function register($username, $password, $nome, $cognome, $numeroTelefono){
        //Controlla se l'utente esiste già
        if($this->getIdByUsername($username)){
            //Utente esiste
            $query = "INSERT INTO account ..."
            $this->query($query);
            return true;
        }else{
            //Utente non esiste
            return false;
        }
    }*/

    public function getIdByUsername($username){
        $query = "SELECT idAccount
                    FROM account
                    WHERE username = '$username'";
        $result = $this->query($query);
        $row = mysqli_fetch_array($result);
        return $row["idAccount"];
    }
}