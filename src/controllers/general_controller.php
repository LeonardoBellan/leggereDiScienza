<?php 

require "controller.php";

class General_controller extends controller{
    public function __construct($book_model, $account_model) {
        parent::__construct($book_model, $account_model);
    }

    public function home($request) {
        //query
        $books = $this->bookmanager->getAllBooks();

        //Preparazione array associativo
        $attributes = [
            "books" => $books];
        $this->renderView("home_view.phtml", $attributes);
    }

    public function error404($request){

        $attributes= [
            "error" => 404,
            "message" => "Impossibile trovare la pagina " . $_SERVER["REQUEST_URI"]
        ];
        /*$attributes["message"] = match($errorCode){
            404 => "La pagina  " . $request["URI"] . " non è stata trovata"
        };*/

        $this->renderView("error_view.phtml", $attributes);
    }
}