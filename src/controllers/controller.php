<?php

class controller
{

    public function __construct()
    {
    }

    private function renderView($template, $data = array())
    {
        //Seleziona la pagina HTML scelta da visualizzare
        $data_JSON =
            require_once "../src/views/$template.phtml";
    }

    private function getModel($model, $DBuser)
    {
        //Ritorna il modello
        require_once "../src/models/$model.php";
        $mdl = new $model($DBuser);
        return $mdl;
    }

    /*
    Controlla se l'utente può accedere ad una determinata risorsa ed in caso contrario lo rimanda alla pagina di errore

    0 - User                         (sempre TRUE)
    1 - Insegnante                   (TRUE solo se livelloAccount >=1)
    2 - Insegnante supervisore       (TRUE solo se livelloAccount ==2)
    */
    private function checkAccountLevel($level)
    {
        $flag = true;
        if ($level > 0) {
            if (!isset($_SESSION["logged"])) {
                $flag = false;
            } else {
                if ($_SESSION["accountLevel"] < $level)
                    $flag = false;
            }
        }
        return $flag;
    }

    public function home()
    {
        //Numero di articoli per pagina
        $numBooksPage=2;

        //Numero di pagina richiesta
        if(isset($_GET["p"]))
            $_SESSION["requested_page"] = (int)$_GET["p"];
        
        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaOspite");//Cambiare utente

        //query
        //Controllo per richiesta di pagina inesistente
        $numLibri = $bookmanager->getNumLibri();
        $numPages = ceil($numLibri/$numBooksPage);
        if((int)$_SESSION["requested_page"]>$numPages){
            header("location: home?p=1");
            return;
        }
        //Richiesta libri per la pagina
        $books = $bookmanager->getLibriLimitedOffset($numBooksPage, (int)$_SESSION["requested_page"] - 1);

        //Preparazione array associativo
        $attributes = [
            "books" => $books,
            "numPages" => $numPages
        ];
        $this->renderView("home_view", $attributes);
    }

    public function error()
    {
        $this->renderView("error_view", ["error" => 404, "message" => "Pagina non trovata"]);
    }

    private function setAccount($idAccount)
    {
        $accountmanager = $this->getModel("account_model", "bibliotecaOspite"); //Cambiare utente

        $_SESSION["logged"] = true;
        $_SESSION["idAccount"] = $idAccount;
        $_SESSION["accountLevel"] = $accountmanager->getLevel($idAccount);
        $_SESSION["accountInfo"] = $accountmanager->getProfessoreById($idAccount);
    }

    public function login()
    {
        $_SESSION["check"]="A";
        if (!$this->checkAccountLevel(0)) {
            header("Location: error");
            return;
        }

        //Quando si arriva dalla home
        if (!isset($_POST["login"])) {
            $this->renderView("login_view", null);
            return;
        }
        $_SESSION["check"]="B";

        //Richiesta modelli necessari
        $accountmanager = $this->getModel("account_model", "bibliotecaOspite"); //Cambiare utente
        //Controllo credenziali
        $idAccount = $accountmanager->login($_POST["username"], $_POST["password"]);
        if ($idAccount) {
            //Credenziali corrette
            $this->setAccount($idAccount);
            header("Location: home");
            $_SESSION["check"]="C";
        } else {
            //Credenziali errate
            $_SESSION["check"]="D";
            $this->renderView("login_view", ["failed" => true]);
        }
        
    }

    public function logout()
    {
        if (!$this->checkAccountLevel(1)) {
            header("Location: error");
        }
        session_unset();
        header("Location: home");
    }

    public function register()
    {
        if (!$this->checkAccountLevel(2)) {
            header("Location: error");
        }

        //Quando si arriva dalla home
        if (!isset($_POST["register"])) {
            $this->renderView("register_view", null);
            return;
        }

        //Richiesta modelli necessari
        $accountmanager = $this->getModel("account_model", "bibliotecaSupervisore");
        //Registrazione
        $username = $_POST["username"];
        $password = $_POST["password"];
        $nome = $_POST["nomeProfessore"];
        $cognome = $_POST["cognomeProfessore"];
        $numeroTelefono = $_POST["numTelefono"];
        $email = $_POST["email"];
        $t = $accountmanager->register($username, $password, $email, $nome, $cognome, $numeroTelefono);
        if ($t) {
            //Registrazione avvenuta con successo
            $this->setAccount($t);
            header("Location: home");
        } else {
            //Errore nella registrazione
            echo "Error"; //TODO
        }
    }

    public function visualizzaLibro()
    {
        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaOspite");        //Cambiare utenti
        $CEmanager = $this->getModel("CE_model", "bibliotecaOspite");

        $idLibro = (int) $_GET["idLibro"];
        $book = $bookmanager->getLibro($idLibro);
        $this->renderView("book_view", $book);
    }

    public function salvaImmagine($numProg)
    {
        // Controllo se è stata inviata un'immagine tramite POST
        if ($_FILES["copertina"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "C:\\xampp\\htdocs\\leggerediscienza\\public\\img\\copertine\\";  // Cartella di destinazione per il salvataggio dell'immagine
            $imageFileType = strtolower(pathinfo(basename($_FILES["copertina"]["name"]), PATHINFO_EXTENSION));
            $target_file = $target_dir . $numProg . "." . $imageFileType;


            // Controllo se il file è un'immagine
            $check = getimagesize($_FILES["copertina"]["tmp_name"]);
            if ($check !== false) {
                // Consentire solo alcuni formati di immagini
                if (
                    $imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"
                    || $imageFileType == "gif"
                ) {
                    // Spostare il file temporaneo nella cartella di destinazione
                    if (move_uploaded_file($_FILES["copertina"]["tmp_name"], $target_file)) {
                        // Ritorna il path del file appena salvato
                        return str_replace("\\", "/", str_replace("C:\\xampp\\htdocs\\leggerediscienza\\public\\", "", $target_file));
                    }
                }
            }

        }
        // Ritorna null se qualcosa fallisce
        return null;
    }

    public function inserisciLibro()
    {
        if (!$this->checkAccountLevel(2)) {
            header("Location: error");
        }

        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaSupervisore");    
        $CEmanager = $this->getModel("CE_model", "bibliotecaSupervisore");
        $tipologiemanager = $this->getModel("tipologie_model", "bibliotecaSupervisore");
        $PCmanager  = $this->getModel("PC_model", "bibliotecaSupervisore");
        $autorimanager = $this->getModel("autori_model", "bibliotecaSupervisore");

        //Quando si arriva dalla home
        if (!isset($_POST["insertBook"])) {
            $caseEditrici = $CEmanager->getAllCE();
            $tipologie = $tipologiemanager->getAllTipologie(); // Da cambiare con tipologiemanager
            $PC  = $PCmanager->getAllParoleChiave();
            $autori= $autorimanager->getAllAutori();

            $data = [
                "caseEditrici" => $caseEditrici,
                "tipologie" => $tipologie,
                "paroleChiave" => $PC,
                "autori" => $autori
            ];
            $this->renderView("insertBook_view", $data);
            return;
        }

        //Inserimento del libro
        $titolo = $_POST["titolo"];
        $ISBN = $_POST["ISBN"];
        $idCE = (isset($_POST["idCasaEditrice"])) ? "'" . $_POST["idCasaEditrice"] . "'" : NULL;
        $trama = (isset($_POST["trama"])) ? "'" . $_POST["trama"] . "'" : NULL;
        $idTipologia = (isset($_POST["idTipologia"])) ? $_POST["idTipologia"] : NULL;
        $dataPubblicazione = $_POST["dataPubblicazione"];
        $disponibilita = (isset($_POST["disponibilita"])) ? 1 : 0;
        $idProfessore = ($_SESSION["accountInfo"])["account"];



        $copertina = $this->salvaImmagine($bookmanager->getNumProgImg()); //Salvare l'immagine sul file server ed inserire il path nel database
        if ($copertina == null) {
            echo "<h1>Errore salvataggio copertina</h1>";
            return;
        } else {
            $bookmanager->incrementNumProgImg();
        }

        //Ricevere anche gli autori, i generi, gli argomenti, le parole chiave

        $bookmanager->insertLibro($ISBN, $titolo, $copertina, $idCE, $trama, $idTipologia, $dataPubblicazione, $disponibilita, $idProfessore);
        //$bookmanager->insertAutoriLibro($idLibro, $autori);
        //$bookmanager->insertGeneriLibro($idLibro, $generi);
        //$bookmanager->insertArgomentiLibro($idLibro, $argomenti); //non esiste piu?
        //$bookmanager->insertParoleChiaveLibro($idLibro, $paroleChiave);
        header("Location: home");
    }
}