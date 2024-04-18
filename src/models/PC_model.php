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

    public function getParolaChiaveById($id){
        $query = "SELECT *
                    FROM parolechiave
                    WHERE idParolaChiave='$id'";
        $result =  $this->query($query);
        
        return $result;
    }

    public function getParoleChiaveByLibro($idLibro){
        $query = "SELECT pc.parolaChiave
                    FROM paroleChiave as pc, paroleLibro as pl
                    WHERE pc.libro='$idLibro' AND pc.idParola=pl.parola";
        $result =  $this->query($query);
        $pc = array();
        while ($row = mysqli_fetch_array($result)) {
            $pc[] = $row;
        }
        return $pc;
    }
}