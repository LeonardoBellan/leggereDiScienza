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
                    AND pwd = MD5('$password')
                    AND attivo = 1";
        
        $result = $this->query($query);
        $row = mysqli_fetch_assoc($result);
        return ($row != NULL) ? $row["idAccount"] : false;
    }
    
    function register($username, $password, $email, $nome, $cognome, $numeroTelefono){
        //Controlla se l'utente esiste già
        if(!$this->getIdByUsername($username)){
            //Utente non esiste
            $query = "INSERT INTO account (username, pwd, attivo) VALUES ('$username', MD5('$password'), 1)";
            $this->query($query);

            $t=$this->getIdByUsername($username);
            $query = "INSERT INTO professori (account, cognome, nome, numeroTelefono, email) 
            VALUES ('$t','$cognome', '$nome', '$numeroTelefono', '$email')";
            $this->query($query);
            return $t;
        }else{
            //Utente esiste
            return false;
        }
    }

    function getProfessoreById($id){
        $query = "SELECT *
                    FROM professori
                    WHERE account = '$id'";
        $result = $this->query($query);
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function getAccountById($id){
        $query = "SELECT *
                    FROM account
                    WHERE account.idAccount = '$id'";
        $result = $this->query($query);
        $row = mysqli_fetch_array($result);
        return $row;
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
        return ($row["supervisore"] != NULL) ? $row["supervisore"]+1 : 0;
    }
}