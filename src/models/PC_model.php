<?php
require_once("model.php");

class PC_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllParoleChiave(){
        $query = "SELECT *
                    FROM parolechiave";
        $result =  $this->query($query);
        $pc = array();
        while ($row = mysqli_fetch_array($result)) {
            $pc[] = $row;
        }
        return $pc;
    }
}