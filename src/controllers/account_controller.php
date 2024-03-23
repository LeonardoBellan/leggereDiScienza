<?php

require "controller.php";

/*  Fatto:
*   Login (Modificare il modello una volta creato il DB account)
*   Logout
*   Register (da fare nel modello)
*/

class account_controller extends controller{
    public function __construct($book_model, $account_model){
        parent::__construct($book_model, $account_model);
    }

    public function login($request){
        //Quando si arriva dalla home
        if(!isset($request["login"])){
            renderView("login_view.phtml", null);
            return;
        }

        //Controllo credenziali
        if($this->accountmanager->login($request["username"], $request["password"])){
            //Credenziali corrette
            $_SESSION["logged"] = true;
            $_SESSION["username"] = $request["username"];
            header("Location: home");
        }else{
            //Credenziali errate
            renderView("login_view.phtml", ["failed" => true]);
        }
    }

    public function logout(){
        unset($_SESSION["logged"]);
        header("Location: home");
    }

    public function register($request) {
        //Quando si arriva dalla home
        if(!isset($request["register"])){
            renderView("register_view.phtml", null);
            return;
        }

        //Registrazione
        if($this->accountmanager->register($request["username"], $request["password"])){
            //Registrazione avvenuta con successo
            $_SESSION["logged"] = true;
            $_SESSION["username"] = $request["username"];
            header("Location: home");
        }else{
            //Errore nella registrazione
            echo "Error"; //TODO
        }
    }
}