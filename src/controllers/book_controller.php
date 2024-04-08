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

    public function inserisciLibro($request){
        $caseEditrici = $this->bookmanager->getAllCE();
        $tipologie = $this->bookmanager->getAllTipologie();
        $data = [
            "caseEditrici"=> $caseEditrici,
            "tipologie"=> $tipologie
        ];
        $this->renderView("insertBook_view.phtml",$data);
    }
}