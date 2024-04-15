<?php
require_once("model.php");

class Autori_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllAutori(){
        $query = "SELECT *
                    FROM autori";
        $result =  $this->query($query);
        $autori = array();
        while ($row = mysqli_fetch_array($result)) {
            $autori[] = $row;
        }
        return $autori;
    }
}