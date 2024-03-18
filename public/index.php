<?php

//Connessione al DB
require_once("../src/models/dbManager.php");
session_start();

if (!isset($_SESSION["connection"])){
    $_SESSION["connection"] = new dbManager("root"); //Da cambiare con USER
}

$resource = getResource($_SERVER['REQUEST_URI']);

echo "Resource: " . $resource . "</br>";

//routing
$controllerName = null;
$action = null;

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){

    //User logged in
    //$_SESSION["connection"].connect("insegnante/insegnanteSupervisore");

    switch($resource){

        //ecc...
    }
}else{
    //User not logged in
    //$_SESSION["connection"].connect("user");
    switch($resource){
        case 'home':
            $controllerName = 'general_controller';
            $action = 'homeAction';
        break;
    
        //ecc...
    }
}

require "../src/controllers/" . $controllerName . ".php";       //Selezione del controller da utilizzare
require_once "../src/models/book_model.php";
require_once "../src/models/account_model.php";

//Inizializzazione dei modelli
$bookModel = new book_model;
$accountModel = new account_model();

//Gestione delle action
$controller = new $controllerName($bookModel, $accountModel);       //Il controller esegue le azioni
$controller->$action($_REQUEST);

/*Non completata
* Gestione utenti
* Gestione utenti DB
* Creazione delle diverse action
* Salvataggio nella sessione
*/

//TODO ottenere le risorse corrette
function getResource($URI){
    $temp = explode("/",$URI);
    $resource = $temp[sizeof($temp)-1]; 

    return $resource;
}