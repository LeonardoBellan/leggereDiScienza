<?php
class model{
    protected $dbConnection;

    public function __construct(){
        $this->dbConnection = $_SESSION["connection"];
    }
}