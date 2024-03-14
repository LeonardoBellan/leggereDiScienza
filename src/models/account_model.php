<?php
session_start();

class account_model{
    private $dbConnection;

    function __construct(){
        $this->dbConnection = $_SESSION["connection"];
    }

    function login($username, $password){
        $query = "SELECT * 
                    FROM account
                    WHERE username = '$username'
                    AND password = md5('$password')";
        $result = mysqli_query($$this->dbConnection, $query);
        $row = $result->fetch_array();
        if($row == NULL){
            
        }
    }
    function userExists($user){

    }
}