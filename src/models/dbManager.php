<?php

class dbManager{
    private $connParameters= [
        'host' => "",
        'port'=> "",
        'user'=> "",
        'password'=> "",
        'dbName'=> ""];        //Informazioni per connettersi al DB [host,porta,user,dbName]
    private $db;                    //Connessione mysqli

    public function __construct($user = null){
        $this->connParameters = $user;
        $this->db = $this->connect();

        //Controlla se la connessione è avvenuta con successo
        if($this->db->connect_error){
            die("connessione fallita ".mysqli_connect_error());                 // se ci sono errori interrompo lo script
        }
    }

    /*
    *Si connette al DB
    *@return mysqli
    */
    private function connect(){

        echo $this->connParameters['host'] .
        $this->connParameters['user'] . 
        $this->connParameters['password']. 
        $this->connParameters['dbName'];
        $conn=new mysqli(
            $this->connParameters['host'],
            $this->connParameters['user'],
            $this->connParameters['password'],
            $this->connParameters['dbName']);

        return $conn;
    }

    //Ritorna la connessione al DB corrente
    public function getConnection(){
        return $this->db;
    }
}

//Non completata
//Gestione degli errori/eccezioni(?)