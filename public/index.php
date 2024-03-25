<?php

/* Variabili della sessione:
*   $_SESSION["logged"] - booleano che indica se l'utente ha fatto l'accesso
*   $_SESSION["username"] - nome dell'utente
*   
*/

//Connessione al DB
session_start();

$resource = getResource($_SERVER['REQUEST_URI']);
echo "Resource: " . $resource . "</br>";

//routing
$DBuser;
$controllerName = null;
$action = null;

if($resource == ''){
    header("Location: home");
    return;
}

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
    //User logged in
    echo "Logged: true </br>";
    switch($resource){
        case 'home':
            $controllerName = 'general_controller';
            $action = 'homeAction';
        break;
        case 'logout':
            $controllerName = 'account_controller';
            $action = 'logout';
            break;

        case 'visualizzaLibro':
            $controllerName = 'book_controller';
            $action = 'visualizzaLibro';
            break;
        //ecc...

        default:
            $controllerName = 'error_controller';
            $action = 'error404';
            break;
    }
}else{
    //User not logged in
    echo "Logged: False </br>";
    switch($resource){
        case 'home':
            $controllerName = 'general_controller';
            $action = 'homeAction';
            break;
        case 'login':
            $controllerName = 'account_controller';
            $action = 'login';
            break;
        case 'register':
            $controllerName = 'account_controller';
            $action = 'register';
            break;
        case 'visualizzaLibro':
            $controllerName = 'book_controller';
            $action = 'visualizzaLibro';
            break;

        //ecc...

        default:
            $controllerName = 'general_controller';
            $action = 'error404';
            break;
    }
}

require "../src/controllers/" . $controllerName . ".php";       //Selezione del controller da utilizzare
require_once "../src/models/book_model.php";
require_once "../src/models/account_model.php";

//Inizializzazione dei modelli
$DBuser = "root";
$bookModel = new book_model($DBuser);
$accountModel = new account_model($DBuser);

//Gestione delle action
$controller = new $controllerName($bookModel, $accountModel);       //Il controller esegue le azioni
$controller->$action($_REQUEST);

//TODO ottenere le risorse corrette
function getResource($URI){

    $url_parts = parse_url($URI);
    $temp = explode("/",$url_parts["path"]);
    $resource = $temp[sizeof($temp)-1]; 

    return $resource;
}