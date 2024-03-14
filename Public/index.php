<?php
session_start();

require "../DBconfig/DBparameters.php";

$routeAction = $_SERVER['REQUEST_URI']; //TODO ottenere le risorse corrette
if(isset($_GET['action'])){
    $routeAction = $_GET['action'];
}

//routing
$controllerName = null;
$controllerName = null;
$action = null;
$DBuser = getDBUser("root");     //#TODO gestione utentiDB
$connectionChanged = false;

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
    //User logged in
    switch($routeAction){
        case 'addBook':
            $controllerName = 'book_controller';
            $action = 'addBook';
        break;
        case 'adduser':
            $controllerName = 'account_controller';
            $action = 'addUser';
        break;

        case 'logout':
            $connectionChanged = true;
        break;
        //ecc...
    }
}else{
    //User not logged in
    //$DBuser = getDBUser("user");
    switch($routeAction){
        case 'login':
            $connectionChanged = true;
            $controllerName = 'account_controller';
            $action = 'login';
        break;
        case 'home':

        break;
    
        //ecc...
    }
}

require "../src/controllers/" . $controllerName . ".php";       //Seleziona il controller da utilizzare
require "../src/models/dbManager.php";
require "../src/models/book_model.php";
require "../src/models/account_model.php";

//Connessione al DB
if(!isset($_SESSION["connection"]) || $connectionChanged = true){
    $db = new dbManager($DBuser);             #IDEA: la connessione si salva nella sessione e non si effettua ogni volta, si cambia quando si effettua il login/logout
    $dbConnection = null;
    if($db){
        $dbConnection = $db->getConnection();
    }
    $_SESSION["connection"] = $dbConnection;
}


//Inizializzazione dei modelli
$accountModel = new account_model();      #TODO creazione di diverse connessioni tramite utenti SQL con poteri limitati
$bookModel = new book_model();

$controller = new $controllerName($accountModel, $bookModel);       //Il controller esegue le azioni


/*Non completata
* Gestione utenti
* Gestione utenti DB
* Creazione delle diverse action
* Salvataggio nella sessione
* Capire come utilizzare le risorse dell'URL
*/
