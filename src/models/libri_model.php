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

    //Funzioni per la ricerca

    //Funzione principale
    public function advancedSearch($filters,  $req)
    {
        $set = ($req) ? " INTERSECT " : " UNION ";
        $query = "";
        if($req){
        $query = "SELECT * 
                    FROM libri";
        }

        foreach ($filters as $key => $value) {
            $funcname=($key . "AddFilter");
            $query .= $set . $this->$funcname($value, ($set) ? "AND" : "OR");
        }

        echo "<p>$query</p>";
        $result = $this->query($query);
        $libri = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $libri[] = $row;
        }
        return $libri;
    }

    private function titoloAddFilter($titolo)
    {
        $str = "SELECT * FROM libri where titolo LIKE '%$titolo%'";
        return $str;
    }

    private function ISBNAddFilter($ISBN)
    {
        $str = "SELECT * FROM libri where ISBN='$ISBN'";
        return $str;
    }

    private function casaEditriceAddFilter($casaEditrice)
    {
        $str = "SELECT * FROM libri where casaEditrice=$casaEditrice";
        /*foreach ($casaEditrice as &$id) {
            $str .= "casaEditrice='$id' OR ";
        }
        $str = rtrim($str, "OR");*/
        return $str;
    }

    private function tipologiaAddFilter($tipologia)
    {
        $str = "SELECT * FROM libri where tipologia=$tipologia";
        /*foreach ($tipologia as &$id) {
            $str .= "tipologia='$id' OR ";
        }
        $str = rtrim($str, "OR");*/
        return $str;
    }

    private function dataPubblicazioneAddFilter($dataPubblicazione)
    {
        $str = "SELECT * FROM libri where ";
        if (isset($dataPubblicazione[0])) {
            $str .= "dataPubblicazione>='" . $dataPubblicazione[0] . "'";
            if (isset($dataPubblicazione[1])) {
                $str .= " AND dataPubblicazione<='" . $dataPubblicazione[0] . "'";
            }
        } else if (isset($dataPubblicazione[1])) {
            $str .= "dataPubblicazione<='" . $dataPubblicazione[0] . "'";
        }
        return $str;
    }

    private function disponibilitaAddFilter($disponibilita)
    {
        if ($disponibilita == 1) {
            $str = "SELECT * FROM libri where disponibilita='$disponibilita'";
        } else
            $str = "";

        return $str;
    }

    private function autoriAddFilter($autori, $set)
    {
        $str = "SELECT libri.*
        FROM libri
        JOIN autorilibro ON libri.idLibro = autorilibro.libro
        JOIN autori ON autorilibro.autore = autori.idAutore
        WHERE ";
        foreach ($autori as &$id) {
            $str .= "autori.idAutore='$id' $set ";
        }

        $str = rtrim($str, $set);

        return $str;
    }

    private function generiAddFilter($generi, $set)
    {
        $str = "SELECT libri.*
        FROM libri
        JOIN generilibro ON libri.idLibro = generilibro.libro
        JOIN generi ON generilibro.genere = generi.idGenere
        WHERE ";
        foreach ($generi as &$id) {
            $str .= "generi.idGenere='$id' $set ";
        }

        $str = rtrim($str, $set);

        return $str;
    }

    private function paroleChiaveAddFilter($PC, $set)
    {
        $str = "SELECT libri.*
        FROM libri
        JOIN parolelibro ON libri.idLibro = parolelibro.libro
        JOIN paroleChiave ON parolelibro.parola = paroleChiave.idParola
        WHERE ";
        foreach ($PC as &$id) {
            $str .= "paroleChiave.idParola='$id' $set";
        }

        $str = rtrim($str, "OR");
        $str = rtrim($str, "AND");

        return $str;
    }
}