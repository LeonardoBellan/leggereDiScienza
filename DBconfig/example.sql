
INSERT INTO autori (nome)
VALUES ('Dante Alighieri'),('J. K. Rowling');

INSERT INTO caseEditrici (nome)
VALUES ('Mondadori'),('Einaudi');

INSERT INTO tipologie (descrizione)
VALUES ('Romanzo'),('Saggio'),('Poema');

INSERT INTO libri (ISBN, titolo, copertina, casaEditrice, trama, tipologia, dataPubblicazione, disponibilita, professore) 
VALUES (1234567890, 'La divina commedia', 'divinaCommedia.png', 1, 'Dante visita linferno', 3, NULL, 0, NULL),
        (123490151, 'Harry Potter e la pietra filosofale', 'HPPietraFilosofale', 2, 'Harry sPotter fa le magie', 1, NULL, 0, NULL);
