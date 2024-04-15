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
        "bibliotecaSupervisore" => "3Qj)<{3l}lh2eAn*",
        "bibliotecaProfessore" => "19:4sa1WT|*pPb_R",
        "bibliotecaOspite" => "2rq{6eqAV:2@>qx0"
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