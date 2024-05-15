<?php

require ("../src/controllers/controller.php");

/* Variabili della sessione:
*   $_SESSION["logged"] - booleano che indica se l'utente ha fatto l'accesso
*   $_SESSION["username"] - nome dell'utente
*   
*/

session_start();
$_SESSION["requested_page"]=1;

$resource = getResource($_SERVER['REQUEST_URI']);
//echo "Resource: " . $resource . "</br>";

//routing
if($resource == ''){
    header("Location: home");
    return;
}

$controller = new controller();       //Il controller esegue le azioni
if(!method_exists($controller, $resource)){
    header("Location: error");
    return;
}
$controller->$resource();

function getResource($URI){

    $url_parts = parse_url($URI);
    $temp = explode("/",$url_parts["path"]);
    $resource = $temp[sizeof($temp)-1]; 

    return $resource;
}