<?php

require_once("dbManager.php");

class model{
    private $dbConnection;

    public function __construct($user){
        $this->dbConnection = new dbManager($user);
    }

    protected function query($sql){
        $result = $this->dbConnection->getConnection()->query($sql);
        return $result;
    }
}