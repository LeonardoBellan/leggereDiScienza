START TRANSACTION;
INSERT INTO account(username, pwd, attivo, supervisore)
VALUES ('leonardo.bellan',md5('password'),1,1),
        ('gianni.rossi',md5('password'),1,0);

INSERT INTO autori (nome)
VALUES ('Dante Alighieri'),
        ('J. K. Rowling');

INSERT INTO caseEditrici (nome)
VALUES ('Mondadori'),
        ('Einaudi');

INSERT INTO tipologie (descrizione)
VALUES ('Romanzo'),
        ('Saggio'),
        ('Poema');

INSERT INTO generi (descrizione)
VALUES ('Fantasy'),
        ('Avventura');

INSERT INTO paroleChiave (parolaChiave)
VALUES ('Inferno'),
        ('Magia'),
        ('Draghi');

INSERT INTO libri (ISBN, titolo, copertina, casaEditrice, trama, tipologia, dataPubblicazione, disponibilita, professore) 
VALUES (1234567890, 'La divina commedia', 'divinaCommedia.png', 1, 'Dante visita linferno', 3, '2000-02-12', 0, 1),
        (123490151, 'Harry Potter e la pietra filosofale', 'HPPietraFilosofale', 2, 'Harry sPotter fa le magie', 1, '2001-04-14', 0, 2);

INSERT INTO autoriLibro (libro, autore) 
VALUES (1,1),
        (2,2);

INSERT INTO generiLibro(libro,genere)
VALUES (1,2),
        (2,1),
        (2,2);

INSERT INTO paroleLibro(libro,parola)
VALUES (1,1),
        (1,3),
        (2,2),
        (2,3);

INSERT INTO recensioni(libro,professore,recensione)
VALUES (1,1,'Dante è un simp'),
        (1,2,'Harry è molto bravo'),
        (2,1,'Trama interessante'),
        (2,2,'Trama non interessante');

COMMIT;

