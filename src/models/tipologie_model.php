<?php
require_once("model.php");

class tipologie_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllTipologie(){
        $query = "SELECT *
                    FROM tipologie";
        $result =  $this->query($query);
        $tipologie = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $tipologie[] = $row;
        }
        return $tipologie;
    }
}