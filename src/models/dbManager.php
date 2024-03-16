<?php

require_once "../DBconfig/DBparameters.php";

class dbManager{
    private $connParameters= [
        'host' => "",
        'port'=> "",
        'user'=> "",
        'password'=> "",
        'dbName'=> ""];        //Informazioni per connettersi al DB [host,porta,user,dbName]
    private $db;                    //Connessione mysqli
    
    public function __construct($user){
        $this->connParameters = getDBUser($user);
        $this->connect($user);

        //Controlla se la connessione è avvenuta con successo
        if($this->db->connect_error){
            die("connessione fallita ".mysqli_connect_error());                 // se ci sono errori interrompo lo script
        }
    }

    /*
    *Si connette al DB
    *@return mysqli
    */
    public function connect($user){
        $this->setConnParameters($user);

        $this->db=new mysqli(
            $this->connParameters['host'],
            $this->connParameters['user'],
            $this->connParameters['password'],
            $this->connParameters['dbName']);

        return $this->db;
    }

    public function setConnParameters($user){
        $this->connParameters = getDBUser( $user);
    }

    //Ritorna la connessione al DB corrente
    public function getConnection(){
        return $this->db;
    }

    public function query($sql){
        $result = mysqli_query($$this->dbConnection, $sql);
        $row = $result->fetch_array();
        return $row;
    }
}

//Non completata
//Gestione degli errori/eccezioni(?)