<?php

require_once ("model.php");

class libri_model extends model
{

    function __construct($user)
    {
        parent::__construct($user);
    }

    public function getAllLibro()
    {
        $query = "SELECT *
                    FROM libri";

        $result = $this->query($query);
        $libri = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $libri[] = $row;
        }
        return $libri;
    }

    public function getLibriLimitedOffset($limit, $offset)
    {
        $offset = $offset * $limit;
        $query = "SELECT * 
                FROM libri
                LIMIT $limit
                OFFSET $offset";

        $result = $this->query($query);
        $libri = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $libri[] = $row;
        }
        return $libri;
    }

    public function getLibro($idLibro)
    {
        $query = "SELECT *
                    FROM libri
                    WHERE idLibro = '$idLibro'";
        $result = $this->query($query);
        return mysqli_fetch_assoc($result);
    }

    public function getIdByISBN($ISBN)
    {
        $query = "SELECT idLibro
                    FROM libri
                    WHERE ISBN = '$ISBN';";
        $result = $this->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['idLibro'];
        } else {
            return null;
        }
    }

    public function insertLibro($ISBN, $titolo, $copertina, $idCasaEditrice, $trama, $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore)
    {
        if (!$this->getIdByISBN($ISBN)) {
            //Libro non esiste
            $query = "INSERT INTO libri (ISBN, titolo, copertina, casaEditrice, trama, tipologia, dataPubblicazione, disponibilita, professore) 
                VALUES ('$ISBN', '$titolo', '$copertina', $idCasaEditrice, '$trama', $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore)
                RETURNING idLibro";
            echo "<script> consle.log('" . $query . "')</script>";
            $result = $this->query($query);
            return mysqli_fetch_assoc($result)["idLibro"];
        } else {
            //Libro esiste
            return null;
        }
    }

    public function insertAutoriLibro($idLibro, $autori)
    {
        $query = "INSERT INTO autorilibro (libro, autore) VALUES ";
        foreach ($autori as &$idAutore) {
            $query = $query . "($idLibro, $idAutore),";
        }
        $query = rtrim($query, ',');

        $result = $this->query($query);

        return ($result) ? true : false;
    }

    public function insertGeneriLibro($idLibro, $generi)
    {
        $query = "INSERT INTO generilibro (libro, genere) VALUES ";
        foreach ($generi as &$idgenere) {
            $query .= "($idLibro, $idgenere),";
        }
        $query = rtrim($query, ',');
        echo "<script>alert('$query')</script>";
        $result = $this->query($query);

        return ($result) ? true : false;
    }

    public function insertParoleChiaveLibro($idLibro, $paroleChiave)
    {
        $query = "INSERT INTO paroleLibro (libro, parola) VALUES ";
        foreach ($paroleChiave as &$idParola) {
            $query .= "($idLibro, $idParola),";
        }
        $query = rtrim($query, ',');

        $result = $this->query($query);

        return ($result) ? true : false;
    }

    public function getNumLibri()
    {
        $query = "SELECT count(*) as c from libri";

        return (int) mysqli_fetch_assoc($this->query($query))["c"];
    }

    public function getNumProgImg()
    {
        $query = "SELECT paramValue from params WHERE paramName='numProgImg'";

        return mysqli_fetch_assoc($this->query($query))["paramValue"];
    }

    public function incrementNumProgImg()
    {
        $oldNum = $this->getNumProgImg();
        $str = str_pad(strval((int) $oldNum + 1), 6, "0", STR_PAD_LEFT);

        $query = "UPDATE params SET paramValue='$str' where paramName='numProgImg'";

        $result = $this->query($query);

        return ($result) ? true : false;
    }
}