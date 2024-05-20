<?php
require_once ("model.php");

class Autori_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getIdByName($nome, $cognome)
    {
        $query = "SELECT *
                    FROM autori
                    WHERE nome = '$nome' AND cognome='$cognome'";
        $result = $this->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['idAutore'];
        } else {
            return null;
        }
    }

    function insertAutore($nome, $cognome)
    {
        //Controlla se l'autore esiste già
        if (!$this->getIdByName($nome, $cognome)) {
            //Autore non esiste
            $query = "INSERT INTO autori (nome, cognome) VALUES ('$nome', '$cognome')";
            $this->query($query);
            return true;
        } else {
            //Autore esiste
            return false;
        }
    }

    function multiInsertAutori($autori)
    {
        foreach ($autori as &$aut) {
            $fullname = $this->splitName($aut);
            $this->insertAutore($fullname[0], $fullname[1]);
        }
    }

    public function splitName($fullname)
    {
        $str = explode(" ", rtrim(strtolower($fullname)));
        $nome = "";
        for ($i = 0; $i < count($str) - 1; $i++) {
            $nome .= ucfirst($str[$i]) . " ";
        }
        $cognome = ucfirst($str[count($str) - 1]);
        return array($nome, $cognome);
    }

    public function getAllAutori()
    {
        $query = "SELECT *
                    FROM autori";
        $result = $this->query($query);
        $autori = array();
        while ($row = mysqli_fetch_array($result)) {
            $autori[] = $row;
        }
        return $autori;
    }

    public function getAutoreById($id)
    {
        $query = "SELECT *
                    FROM autori
                    WHERE idAutore='$id'";
        $result = $this->query($query);
        return $result;
    }

    public function getAutoriByLibro($idLibro)
    {
        $query = "SELECT *
                    FROM autori
                    WHERE idAutore IN 
                        (SELECT autore FROM libri WHERE idLibro='$idLibro')";
        $result = $this->query($query);
        return $result;
    }
}