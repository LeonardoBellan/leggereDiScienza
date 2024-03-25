<?php
class model{
    private $dbConnection;

    public function __construct($user){
        $this->dbConnection = new dbManager($user);
    }

    protected function query($sql){
        echo "Query: " . $sql . "</br>";
        return $this->dbConnection->getConnection()->query($sql);
    }

    /*
    protected function changeConnection($username){
        
    }

    */
}