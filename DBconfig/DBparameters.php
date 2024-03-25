<?php

/* Configurazione dei parametri per la connessione al DB
*   e dei dati degli utenti del DB
*
* @return: array["host","port","dbName","user","password"]
*/
function getDBUser($userNameDB){
    $host = "localhost";
    $port = "3306";
    $dbName = "leggereDiScienza";
    /*$password = match($userNameDB){
        "root" => "",
        "insegnanteSupervisore" => "",
        "insegnante" => "",
        "user" => ""
    };*/

    $password = "";

    return [
        "host"=> $host,
        "port"=> $port,
        "dbName"=> $dbName,
        "user"=> $userNameDB,
        "password"=> $password
    ];
}

//Completata