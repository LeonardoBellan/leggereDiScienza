<?php 

require "controller.php";

class General_controller extends controller{
    public function __construct($book_model, $account_model) {
        parent::__construct($book_model, $account_model);
    }

    public function homeAction($request) {
        //query
        $books = $this->bookmanager->getAllBooks();

        //Preparazione array associativo
        $vars = [
            "books" => $books];
        renderView("home_view.phtml", $vars);
    }
}