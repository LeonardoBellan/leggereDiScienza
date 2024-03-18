<?php 

require "../src/models/book_model.php";
require "../src/models/account_model.php";
require "../src/views/renderView.php";

class General_controller {

    private $bookmanager;
    private $accountmanager;
    public function __construct($book_model, $account_model) {

        $this->bookmanager = $book_model;

        $this->accountmanager = $account_model;
    }

    public function homeAction($request) { 
        $arr = $this->bookmanager->getAllBooks();
        renderView("home", $arr);
    }
}