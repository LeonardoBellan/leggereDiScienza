START TRANSACTION;

/*
--Account
--PK: idAccount
*/
DROP TABLE IF EXISTS account;
CREATE TABLE account (
    idAccount int primary key auto_increment,
    username varchar(30) NOT NULL,
    pwd varchar(30) NOT NULL,
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
    account int PRIMARY KEY,
        FOREIGN KEY (account)
        REFERENCES account(idAccount),
    cognome varchar(20) NOT NULL,
    nome varchar(20) NOT NULL,
    numeroTelefono char(10),
    email varchar(30)
);

/*
--Autori
--PK: idAutore
*/
DROP TABLE IF EXISTS autori;
CREATE TABLE autori(
    idAutore int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(40),
    cognome varchar(40)
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
    tipologia varchar(20) NOT NULL
);

/*
--Generi
--PK: idGenere
*/
DROP TABLE IF EXISTS generi;
CREATE TABLE generi(
    idGenere int PRIMARY KEY AUTO_INCREMENT,
    genere varchar(20) NOT NULL
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
    trama varchar(200),
    tipologia int, 
        FOREIGN KEY(tipologia) 
        REFERENCES tipologie(idTipologia) 
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    dataPubblicazione date,
    disponibilita bit NOT NULL,                /*disponibilità in biblioteca (Per la futura biblioteca del Kennedy)*/
    professore int,                            /*Professore che ha inserito il libro*/
        FOREIGN KEY(professore) 
        REFERENCES professori(account)
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
        REFERENCES professori(account)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    PRIMARY KEY(libro, professore),
    recensione text NOT NULL
);

CREATE USER IF NOT EXISTS 'bibliotecaOspite'@'%' IDENTIFIED BY "2rq{6eqAV:2@>qx0";
REVOKE ALL ON *.* FROM 'bibliotecaOspite'@'%';
GRANT SELECT ON leggerediscienza.* to 'bibliotecaOspite'@'%';

CREATE USER IF NOT EXISTS 'bibliotecaProfessore'@'%' IDENTIFIED BY "19:4sa1WT|*pPb_R";
REVOKE ALL ON *.* FROM 'bibliotecaProfessore'@'%';
GRANT SELECT ON leggerediscienza.* to 'bibliotecaProfessore'@'%';
GRANT INSERT ON leggerediscienza.recensioni to 'bibliotecaProfessore'@'%';

CREATE USER IF NOT EXISTS 'bibliotecaSupervisore'@'%' IDENTIFIED BY "3Qj)<{3l}lh2eAn*";
REVOKE ALL ON *.* FROM 'bibliotecaSupervisore'@'%';
GRANT SELECT ON leggerediscienza.* to 'bibliotecaSupervisore'@'%';
GRANT INSERT ON leggerediscienza.* to 'bibliotecaSupervisore'@'%';

COMMIT;