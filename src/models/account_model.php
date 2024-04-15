<?php

require_once("model.php");

class account_model extends model{

    function __construct($DBuser){
        parent::__construct($DBuser);
    }

    public function login($username, $password){
        $query = "SELECT idAccount 
                    FROM account
                    WHERE username = '$username'
                    AND password = '$password'
                    AND attivo = 1";
        
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return ($result != NULL) ? $row["idAccount"] : false;
    }
    
    function register($username, $password, $email, $nome, $cognome, $numeroTelefono){
        //Controlla se l'utente esiste già
        if(!$this->getIdByUsername($username)){
            //Utente esiste
            $query = "INSERT INTO account ...";
            $this->query($query);
            return true;
        }else{
            //Utente non esiste
            return false;
        }
    }

    function getProfessoreById($id){
        $query = "SELECT *
                    FROM professori
                    WHERE account = '$id'";
        $result = $this->query($query);
        $row = mysqli_fetch_array($result);
        return $row["idAccount"];
    }

    function getAccountById($id){
        $query = "SELECT *
                    FROM account
                    WHERE account.idAccount = '$id'";
        $result = $this->query($query);
        $row = mysqli_fetch_array($result);
        return $row["idAccount"];
    }



    public function getIdByUsername($username){
        $query = "SELECT idAccount
                    FROM account
                    WHERE username = '$username'";
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row["idAccount"];
    }

    public function getLevel( $idAccount){
        $query = "SELECT supervisore
                    FROM account
                    WHERE idAccount = '$idAccount'";
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row["supervisore"];
    }
}