<?php 

require_once "../src/models/dbManager.php";
require "../src/models/book_model.php";
require "../src/models/account_model.php";
require "../src/views/renderView.php";

class General_controller {

    private $bookmanager;
    private $accountManager;
    public function __construct($book_model, $account_model) {

        $this->bookManager = $book_model;
        $this->accountManager = $account_model;

    }

    public function homeAction($request) {
        $query = "select * from clienti";
        $arr = $_SESSION["connection"]->query($query);
        renderView("home", $arr);
    }
}