<?php

require_once("model.php");

class libri_model extends model{

    function __construct($user){
        parent::__construct($user);
    }

    public function getAllLibro(){
        $query = "SELECT *
                    FROM libri";
                    
        $result =  $this->query($query);
        $libri = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $libri[] = $row;
        }
        return $libri;
    }

    public function getLibriLimitedOffset($limit, $offset){
        $offset=$offset*$limit;
        $query="SELECT * 
                FROM libri
                LIMIT $limit
                OFFSET $offset";

        $result =  $this->query($query);
        $libri = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $libri[] = $row;
        }
        return $libri;
    }

    public function getLibro($idLibro){
        $query = "SELECT *
                    FROM libri
                    WHERE idLibro = '$idLibro'";
        $result =  $this->query($query);
        return mysqli_fetch_assoc($result);
    }

    public function getIdByTitle($titolo){
        $query = "SELECT idLibro
                    FROM libri
                    WHERE titolo = '$titolo'";
        $result =  $this->query($query);
        return mysqli_fetch_assoc($result)["idLibro"];
    }

    public function insertLibro($ISBN, $titolo, $copertina, $idCasaEditrice, $trama, $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore){
        $query = "INSERT INTO libri (ISBN, titolo, copertina, casaEditrice, trama, tipologia, dataPubblicazione, disponibilita, professore) 
                VALUES ('$ISBN', '$titolo', '$copertina', $idCasaEditrice, '$trama', $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore)";
        $result = $this->query($query);
        
        return ($result) ? true : false;
    }

    public function insertAutoriLibro($idLibro, $autori){
        $query = "INSERT INTO autorilibro (libro, autore) VALUES ";
        foreach($autori as &$idAutore){
            $query.="($idLibro, $idAutore),";
        }
        $query=$query.rtrim(',');

        $result = $this->query($query);
        
        return ($result) ? true : false;
    }

    public function insertGeneriLibro($idLibro, $generi){
        $query = "INSERT INTO generilibro (libro, genere) VALUES ";
        foreach($generi as &$idgenere){
            $query.="($idLibro, $idgenere),";
        }
        $query=$query.rtrim(',');

        $result = $this->query($query);
        
        return ($result) ? true : false;
    }

    public function insertParoleChiaveLibro($idLibro, $paroleChiave){
        $query = "INSERT INTO paroleLibro (libro, parola) VALUES ";
        foreach($paroleChiave as &$idParola){
            $query.="($idLibro, $idParola),";
        }
        $query=$query.rtrim(',');

        $result = $this->query($query);
        
        return ($result) ? true : false;
    }

    public function getNumLibri(){
        $query = "SELECT count(*) as c from libri";
        
        return (int)mysqli_fetch_assoc($this->query($query))["c"];
    }

    public function getNumProgImg(){
        $query = "SELECT paramValue from params WHERE paramName='numProgImg'";
        
        return mysqli_fetch_assoc($this->query($query))["paramValue"];
    }

    public function incrementNumProgImg(){
        $oldNum=$this->getNumProgImg();
        $str = str_pad(strval((int)$oldNum+1),6,"0", STR_PAD_LEFT);
        
        $query = "UPDATE params SET paramValue='$str' where paramName='numProgImg'";

        $result = $this->query($query);
        
        return ($result) ? true : false;
    }
}