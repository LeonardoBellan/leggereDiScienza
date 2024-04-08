START TRANSACTION;


/*
--Account
--PK: idAccount
*/
DROP TABLE IF EXISTS account;
CREATE TABLE account (
    idAccount int primary key auto_increment,
    username varchar(30) NOT NULL,
    password varchar(30) NOT NULL,
    attivo bit NOT NULL default 0,
    supervisore bit NOT NULL default 0,
    dataCreazione date DEFAULT CURRENT_TIMESTAMP
);

/*
--Professori
--PK: idProfessore
*/
DROP TABLE IF EXISTS professori;
CREATE TABLE professori(
    idAccount int PRIMARY KEY,
        FOREIGN KEY (idAccount)
        REFERENCES account(idAccount);
    idAccount int,
        FOREIGN KEY(idAccount) 
        REFERENCES account(idAccount),
    cognome varchar(20) NOT NULL,
    nome varchar(20) NOT NULL,
    numeroTelefono char(10)
);

/*
--Autori
--PK: idAutore
*/
DROP TABLE IF EXISTS autori;
CREATE TABLE autori(
    idAutore int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(40)
);

/*
--Case editrici
--PK: idCasaEditrice
*/
DROP TABLE IF EXISTS caseEditrici;
CREATE TABLE caseEditrici (
    idCasaEditrice int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(20) NOT NULL
);

/*
--Tipologie (Saggio, romanzo, ...)
--PK: idTiplogia
*/
DROP TABLE IF EXISTS tipologie;
CREATE TABLE tipologie(
    idTipologia int PRIMARY KEY AUTO_INCREMENT,
    descrizione varchar(20) NOT NULL
);

/*
--Generi
--PK: idGenere
*/
DROP TABLE IF EXISTS generi;
CREATE TABLE generi(
    idGenere int PRIMARY KEY AUTO_INCREMENT,
    descrizione varchar(20) NOT NULL
);

/*
--Parole chiave
--PK: idParola
*/
DROP TABLE IF EXISTS paroleChiave;
CREATE TABLE paroleChiave(
    idParola int PRIMARY KEY AUTO_INCREMENT,
    parolaChiave varchar(20)
);

/*
--Libri
--PK: idLibro
*/
DROP TABLE IF EXISTS libri;
CREATE TABLE libri (
    idLibro int PRIMARY KEY AUTO_INCREMENT,
    ISBN varchar(13) NOT NULL,
    titolo varchar(40) NOT NULL,
    copertina varchar(40) NOT NULL,           /*path of the image*/
    casaEditrice int, 
        FOREIGN KEY(casaEditrice) 
        REFERENCES caseEditrici(idCasaEditrice) 
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    trama text,
    tipologia int, 
        FOREIGN KEY(tipologia) 
        REFERENCES tipologie(idTipologia) 
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    dataPubblicazione date,
    disponibilita bit NOT NULL,                /*disponibilità in biblioteca (Per la futura biblioteca del Kennedy)*/

    professore int,                            /*Professore che ha inserito il libro*/
        FOREIGN KEY(professore) 
        REFERENCES professori(idProfessore)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


/*
--AutoriLibro
--PK: libro,autore
*/
DROP TABLE IF EXISTS autoriLibro;
CREATE TABLE autoriLibro(
    libro int, 
        FOREIGN KEY(libro) 
        REFERENCES libri(idLibro) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    autore int, 
        FOREIGN KEY(autore) 
        REFERENCES autori(idAutore) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    PRIMARY KEY(libro,autore)
);

/*
--GeneriLibro
--PK: libro, genere
*/
DROP TABLE IF EXISTS generiLibro;
CREATE TABLE generiLibro(
    libro int, 
        FOREIGN KEY(libro) 
        REFERENCES libri(idLibro) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    genere int, 
        FOREIGN KEY(genere) 
        REFERENCES generi(idGenere) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    PRIMARY KEY(libro,genere)
);

/*
--Parole chiave per libro
--PK: libro, parola
*/
DROP TABLE IF EXISTS paroleLibro;
CREATE TABLE paroleLibro(
    libro int, 
        FOREIGN KEY(libro) 
        REFERENCES libri(idLibro) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    parola int, 
        FOREIGN KEY(parola) 
        REFERENCES paroleChiave(idParola) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    PRIMARY KEY(libro,parola)
);

/*
--Recensioni
--PK: libro, professore
*/
DROP TABLE IF EXISTS recensioni;
CREATE TABLE recensioni(
    libro int NOT NULL, 
        FOREIGN KEY(libro) 
        REFERENCES libri(idLibro)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    professore int NOT NULL, 
        FOREIGN KEY(professore) 
        REFERENCES professori(idProfessore)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    PRIMARY KEY(libro, professore),
    recensione text NOT NULL
);



/*
--TODO
DROP TABLE IF EXISTS account;
CREATE TABLE account (

);

--Non completato
--Creazione di tutte le tabelle necessarie
*/

CREATE USER IF NOT EXISTS bibliotecaOspite@% IDENTIFIED BY "2rq{6eqAV:2@>qx0";
REVOKE ALL PRIVILEGES ON *.* TO bibliotecaOspite@localhost;
GRANT SELECT ON biblioteca.* to bibliotecaOspite@localhost;

CREATE USER IF NOT EXISTS bibliotecaProfessore@% IDENTIFIED BY "19:4sa1WT|*pPb_R";
REVOKE ALL PRIVILEGES ON *.* TO bibliotecaProfessore@localhost;
GRANT SELECT ON biblioteca.* to bibliotecaProfessore@localhost;
REVOKE INSERT ON biblioteca.* to bibliotecaProfessore@localhost;
GRANT INSERT ON biblioteca.recensioni to bibliotecaProfessore@localhost;

CREATE USER IF NOT EXISTS bibliotecaSupervisore@localhost IDENTIFIED BY "3Qj)<{3l}lh2eAn*";
REVOKE ALL PRIVILEGES ON *.* TO bibliotecaProfessore@localhost;
GRANT SELECT ON biblioteca.* to bibliotecaProfessore@localhost;
GRANT INSERT ON biblioteca.* to bibliotecaProfessore@localhost;

COMMIT;