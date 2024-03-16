<?php

function renderView($template, $vars=array()){

    //Seleziona la pagina HTML scelta da visualizzare
    switch($template){
        case "home":
            require("home_view.phtml");
        break;
    }
}