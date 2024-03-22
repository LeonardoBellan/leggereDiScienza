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
        //query
        $result = $this->bookmanager->getAllBooks();

        //Preparazione array associativo
        $books = array();
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $books[$i] = $row;
        }
        $vars = [
            "books" => $books
        ];
        renderView("home_view.phtml", $vars);
    }
}