<?php
session_start();

//Connessione al DB
require_once("../src/models/dbManager.php");

if (!isset($_SESSION["connection"])){
    $_SESSION["connection"] = new dbManager("root"); //Da cambiare con USER
}

$route = $_SERVER['REQUEST_URI'];
$temp = explode("/",$route);
$routeAction = $temp[sizeof($temp)-1]; //TODO ottenere le risorse corrette

echo "Resource: " . $routeAction;

//routing
$controllerName = null;
$action = null;
$connectionChanged = false;

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
    //User logged in
    //$_SESSION["connection"].connect("insegnante/insegnanteSupervisore");

    switch($routeAction){

        //ecc...
    }
}else{
    //User not logged in
    //$_SESSION["connection"].connect("user");
    switch($routeAction){
        case 'home':
            $controllerName = 'general_controller';
            $action = 'homeAction';
        break;
    
        //ecc...
    }
}

require "../src/controllers/" . $controllerName . ".php";       //Seleziona il controller da utilizzare
require_once "../src/models/book_model.php";
require_once "../src/models/account_model.php";

//Inizializzazione dei modelli
$accountModel = new account_model();      #TODO creazione di diverse connessioni tramite utenti SQL con poteri limitati
//$bookModel = new book_model();

$controller = new $controllerName($accountModel, $bookModel);       //Il controller esegue le azioni
$controller->$action($_REQUEST);

/*Non completata
* Gestione utenti
* Gestione utenti DB
* Creazione delle diverse action
* Salvataggio nella sessione
* Capire come utilizzare le risorse dell'URL
*/

