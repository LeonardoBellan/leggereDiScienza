<?php
require "controller.php";
class book_controller extends controller{
    public function __construct($book_model, $account_model){
        parent::__construct($book_model, $account_model);
    }

    public function visualizzaLibro($request){
        $idLibro = $request["idLibro"];
        $book = $this->bookmanager->informazioniLibro($idLibro);
        $this->renderView("book_view.phtml",$book);
    }
    
}