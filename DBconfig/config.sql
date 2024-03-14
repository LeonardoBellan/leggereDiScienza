--TODO Creazione tabelle ed utenti (user,insegnante,insegnanteSupervisore)

--Case editrici
DROP TABLE IF EXISTS 'caseEditrici';
CREATE TABLE 'caseEditrici' (
    'idCasaEditrice' int PRIMARY KEY AUTO_INCREMENT,
    'nome' varchar(20) NOT NULL
);

--Tipologie (Saggio, romanzo, ...)
DROP TABLE IF EXISTS 'tipologie'
CREATE TABLE 'tipologie'(
    'idTipologia' int PRIMARY KEY AUTO_INCREMENT,
    'descrizione' varchar(20) NOT NULL
);

--Professori
DROP TABLE IF EXISTS 'professori'
CREATE TABLE 'professori'(
    'idProfessore' int PRIMARY KEY AUTO_INCREMENT,
    'cognome' varchar(20) NOT NULL,
    'nome' varchar(20) NOT NULL,
    'numeroTelefono' varchar(10)
);

--Libri
DROP TABLE IF EXISTS 'libri';
CREATE TABLE `libri` (
    'idLibro' int PRIMARY KEY AUTO_INCREMENT,
    'ISBN' int(13) NOT NULL,
    'titolo' varchar(25) NOT NULL,
    'copertina' varchar(40) NOT NULL,           --path of the image
    'casaEditrice' int, FOREIGN KEY('casaEditrice') REFERENCES caseEditrici(idCasaEditrice),
    'trama' varchar(200),
    'tipologia' int, FOREIGN KEY('tipologia') REFERENCES tipologie(idTipologia),
    'disponibilita' bit NOT NULL,                --disponibilità in biblioteca (Per la futura biblioteca del Kennedy)

    'professore' int, FOREIGN KEY('professore') REFERENCES professori(idProfessore)   --Professore che ha inserito il libro
);

--Recensioni
DROP TABLE IF EXISTS 'recensioni'
CREATE TABLE 'recensioni'(
    'libro' int NOT NULL, FOREIGN KEY('libro') REFERENCES libri(idLibro),
    'professore' int NOT NULL, FOREIGN KEY('professore') REFERENCES professori(idProfessore),
    PRIMARY KEY('libro', 'professore'),
    'recensione' varchar(400) NOT NULL
);

--AutoriLibro
--PK: libro,autore
DROP TABLE IF EXISTS 'autoriLibro'
CREATE TABLE 'autoriLibro'(
    'libro' int, FOREIGN KEY('libro') REFERENCES libri(idLibro),
    'autore' int, FOREIGN KEY('autore') REFERENCES autori(idAutore),
    PRIMARY KEY('libro','autore')
);

DROP TABLE IF EXISTS 'account';
--TODO
CREATE TABLE `account` (

);

--Non completato
--Creazione di tutte le tabelle necessarie