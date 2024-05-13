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

    0 - User
    1 - Insegnante
    2 - Insegnante supervisore
    */
    private function checkAccountLevel($level)
    {
        $flag = true;
        if ($level == 2 && $_SESSION["accountLevel"] != 1) {
            $flag = false;
        }
        if ($level != isset($_SESSION["logged"])) {
            $flag = false;
        }
        return $flag;
    }

    public function home()
    {
        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaOspite");//Cambiare utente

        //query
        $books = $bookmanager->getAllLibro();

        //Preparazione array associativo
        $attributes = [
            "books" => $books
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
    }

    public function login()
    {
        if (!$this->checkAccountLevel(0)){
            header("Location: error");
        }

        //Quando si arriva dalla home
        if (!isset($_POST["login"])) {
            $this->renderView("login_view", null);
            return;
        }

        //Richiesta modelli necessari
        $accountmanager = $this->getModel("account_model", "bibliotecaOspite"); //Cambiare utente
        //Controllo credenziali
        $idAccount = $accountmanager->login($_POST["username"], $_POST["password"]);
        if ($idAccount) {
            //Credenziali corrette
            $this->setAccount($idAccount);
            header("Location: home");
        } else {
            //Credenziali errate
            $this->renderView("login_view", ["failed" => true]);
        }
    }

    public function logout()
    {
        if (!$this->checkAccountLevel(1)){
            header("Location: error");
        }
        session_unset();
        header("Location: home");
    }

    public function register() {
        if (!$this->checkAccountLevel(2)){
            header("Location: error");
        }

        //Quando si arriva dalla home
        if(!isset($_POST["register"])){
            $this->renderView("register_view", null);
            return;
        }
        
        //Richiesta modelli necessari
        $accountmanager = $this->getModel("account_model","bibliotecaSupervisore"); 
        //Registrazione
        $username = $_POST["username"];
        $password = $_POST["password"];
        $nome = $_POST["nomeProfessore"];
        $cognome = $_POST["cognomeProfessore"];
        $numeroTelefono = $_POST["numTelefono"];
        $email = $_POST["email"];
        if($accountmanager->register($username, $password, $email, $nome, $cognome, $numeroTelefono)){
            //Registrazione avvenuta con successo
            setAccount($idAccount);
            header("Location: home");
        }else{
            //Errore nella registrazione
            echo "Error"; //TODO
        }
    }

    public function visualizzaLibro()
    {
        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaOspite");        //Cambiare utenti
        $CEmanager = $this->getModel("CE_model", "bibliotecaOspite");

        $idLibro = $_POST["idLibro"];
        $book = $bookmanager->getLibro($idLibro);
        $this->renderView("book_view", $book);
    }

    public function inserisciLibro()
    {
        if (!$this->checkAccountLevel(2)){
            header("Location: error");
        }

        //Richiesta modelli necessari
        $bookmanager = $this->getModel("libri_model", "bibliotecaSupervisore");    //Cambiare utenti
        $CEmanager = $this->getModel("CE_model", "bibliotecaSupervisore");
        $tipologiemanager = $this->getModel("tipologie_model", "bibliotecaSupervisore");

        //Quando si arriva dalla home
        if (!isset($_POST["insertBook"])) {
            $caseEditrici = $CEmanager->getAllCE();
            $tipologie = $tipologiemanager->getAllTipologie(); // Da cambiare con tipologiemanager
            $data = [
                "caseEditrici" => $caseEditrici,
                "tipologie" => $tipologie
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
        $idProfessore = $_SESSION["idProfessore"];

        $copertina = 0; //Salvare l'immagine sul file server ed inserire il path nel database

        //Ricevere anche gli autori, i generi, gli argomenti, le parole chiave
        /*
        $bookmanager->insertBook($ISBN,$titolo,$copertina,$idCE,$trama,$idTipologia,$dataPubblicazione,$disponibilita,$idProfessore);
        $bookmanager->insertAutoriLibro($idLibro, $autori);
        $bookmanager->insertGeneriLibro($idLibro, $generi);
        $bookmanager->insertArgomentiLibro($idLibro, $argomenti); //non esiste piu?
        $bookmanager->insertParoleChiaveLibro($idLibro, $paroleChiave);
        */
    }
}