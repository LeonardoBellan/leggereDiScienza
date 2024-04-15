<?php
require_once("model.php");

class CE_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllCE(){
        $query = "SELECT *
                    FROM caseEditrici";
        $result =  $this->query($query);
        $CE = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $CE[] = $row;
        }
        return $CE;
    }
}