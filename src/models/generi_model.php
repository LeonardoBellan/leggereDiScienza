<?php
require_once("model.php");

class Generi_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllGeneri(){
        $query = "SELECT *
                    FROM generi";
        $result =  $this->query($query);
        $generi = array();
        while ($row = mysqli_fetch_array($result)) {
            $generi[] = $row;
        }
        return $generi;
    }
}