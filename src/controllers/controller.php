<?php

require_once "../src/models/book_model.php";
require_once "../src/models/account_model.php";
require_once "../src/views/renderView.php";

class controller{
    protected $bookmanager;
    protected $accountmanager;
    public function __construct($book_model, $account_model){
        $this->bookmanager = $book_model;
        $this->accountmanager = $account_model;
    }
}