-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 27, 2024 alle 02:24
-- Versione del server: 10.5.25-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leggerediscienza`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `account`
--

CREATE TABLE `account` (
  `idAccount` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` char(100) NOT NULL,
  `attivo` bit(1) NOT NULL DEFAULT b'0',
  `supervisore` bit(1) NOT NULL DEFAULT b'0',
  `dataCreazione` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `account`
--

INSERT INTO `account` (`idAccount`, `username`, `pwd`, `attivo`, `supervisore`, `dataCreazione`) VALUES
(3, 'aaa', '47bce5c74f589f4867dbd57e9ca9f808', b'1', b'0', '2024-05-14'),
(4, 'bbb', '08f8e0260c64418510cefb2b06eee5cd', b'1', b'1', '2024-05-14');

-- --------------------------------------------------------

--
-- Struttura della tabella `autori`
--

CREATE TABLE `autori` (
  `idAutore` int(11) NOT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `cognome` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `autori`
--

INSERT INTO `autori` (`idAutore`, `nome`, `cognome`) VALUES
(1, 'J. K. ', 'Rowling'),
(2, 'j.  k. ', 'rowling'),
(3, 'j. k. ', ''),
(4, 'j.  k. ', ''),
(5, '', 'A'),
(6, 'Matej ', 'Derma'),
(7, 'J. ', 'K.');

-- --------------------------------------------------------

--
-- Struttura della tabella `autorilibro`
--

CREATE TABLE `autorilibro` (
  `libro` int(11) NOT NULL,
  `autore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `autorilibro`
--

INSERT INTO `autorilibro` (`libro`, `autore`) VALUES
(30, 1),
(30, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `caseeditrici`
--

CREATE TABLE `caseeditrici` (
  `idCasaEditrice` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `caseeditrici`
--

INSERT INTO `caseeditrici` (`idCasaEditrice`, `nome`) VALUES
(1, 'Mondadori'),
(2, 'Minimum Fax'),
(3, 'Minimum Fax'),
(4, 'Cairo'),
(5, 'Baldini e Castoldi'),
(6, 'Fanucci'),
(7, 'Hoepli'),
(8, 'Castelvecchi'),
(9, 'Ancora'),
(10, 'Neri Pozza'),
(11, 'Fazi editore'),
(12, 'Bloomsberry'),
(13, 'pene');

-- --------------------------------------------------------

--
-- Struttura della tabella `generi`
--

CREATE TABLE `generi` (
  `idGenere` int(11) NOT NULL,
  `genere` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `generi`
--

INSERT INTO `generi` (`idGenere`, `genere`) VALUES
(1, 'Giallo'),
(2, 'Fantascienza'),
(3, 'Horror'),
(4, 'Thriller'),
(5, 'Distopia'),
(6, 'Avventura'),
(7, 'Azione'),
(26, 'A'),
(27, 'Informativo');

-- --------------------------------------------------------

--
-- Struttura della tabella `generilibro`
--

CREATE TABLE `generilibro` (
  `libro` int(11) NOT NULL,
  `genere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `generilibro`
--

INSERT INTO `generilibro` (`libro`, `genere`) VALUES
(26, 6),
(29, 5),
(29, 6),
(29, 7),
(30, 1),
(30, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `libri`
--

CREATE TABLE `libri` (
  `idLibro` int(11) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `titolo` varchar(40) NOT NULL,
  `copertina` varchar(100) NOT NULL,
  `casaEditrice` int(11) DEFAULT NULL,
  `trama` varchar(200) DEFAULT NULL,
  `tipologia` int(11) DEFAULT NULL,
  `dataPubblicazione` date DEFAULT NULL,
  `disponibilita` bit(1) NOT NULL,
  `professore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `libri`
--

INSERT INTO `libri` (`idLibro`, `ISBN`, `titolo`, `copertina`, `casaEditrice`, `trama`, `tipologia`, `dataPubblicazione`, `disponibilita`, `professore`) VALUES
(11, '978-880473037', '1984', 'img/copertine/000001.jpg', 1, '', 1, '0000-00-00', b'0', 4),
(17, '123-456789123', 'titolo', 'img/copertine/000029.jpg', 9, '', 3, '0000-00-00', b'0', 4),
(18, '123-456789456', 'Harry Potter 1', 'img/copertine/000031.jpg', 12, '', 1, '0000-00-00', b'0', 4),
(19, '123-456789789', 'Harry Potter 2', 'img/copertine/000032.jpg', 10, '', 3, '0000-00-00', b'0', 4),
(20, '123-456789111', 'Harry Potter 3', 'img/copertine/000033.jpg', 9, '', 3, '0000-00-00', b'0', 4),
(21, '123-456789222', 'Harry Potter 4', 'img/copertine/000034.jpg', 9, '', 4, '0000-00-00', b'0', 4),
(22, '123-456789223', 'Harry Potter 5', 'img/copertine/000035.jpg', 7, '', 3, '0000-00-00', b'0', 4),
(23, '123-456789888', 'Harry Potter 6', 'img/copertine/000036.jpg', 7, '', 3, '0000-00-00', b'0', 4),
(24, '123-456789999', 'Harry Potter 7', 'img/copertine/000037.jpg', 5, '', 3, '0000-00-00', b'0', 4),
(25, '123-456789475', 'Harry Potter 8', 'img/copertine/000038.jpg', 9, '', 3, '0000-00-00', b'0', 4),
(26, '123-456789129', 'Harry Proper', 'img/copertine/000039.jpg', 7, '', 5, '0000-00-00', b'0', 4),
(29, '222-222222222', 'derma biografia', 'img/copertine/000043.jpg', 7, '', 3, '0000-00-00', b'0', 4),
(30, '333-333333333', 'proviamophp', 'img/copertine/000044.jpg', 5, '', 1, '0000-00-00', b'0', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `params`
--

CREATE TABLE `params` (
  `paramName` varchar(100) NOT NULL,
  `paramValue` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `params`
--

INSERT INTO `params` (`paramName`, `paramValue`) VALUES
('numProgImg', '000048');

-- --------------------------------------------------------

--
-- Struttura della tabella `parolechiave`
--

CREATE TABLE `parolechiave` (
  `idParola` int(11) NOT NULL,
  `parolaChiave` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `parolechiave`
--

INSERT INTO `parolechiave` (`idParola`, `parolaChiave`) VALUES
(1, 'magia'),
(2, 'castello'),
(3, 'C'),
(4, 'Php'),
(5, 'Informatica'),
(6, 'Web app');

-- --------------------------------------------------------

--
-- Struttura della tabella `parolelibro`
--

CREATE TABLE `parolelibro` (
  `libro` int(11) NOT NULL,
  `parola` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `parolelibro`
--

INSERT INTO `parolelibro` (`libro`, `parola`) VALUES
(26, 1),
(26, 2),
(29, 1),
(29, 2),
(29, 5),
(29, 6),
(30, 1),
(30, 4),
(30, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `professori`
--

CREATE TABLE `professori` (
  `account` int(11) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `numeroTelefono` char(10) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `professori`
--

INSERT INTO `professori` (`account`, `cognome`, `nome`, `numeroTelefono`, `email`) VALUES
(3, 'derma', 'matej', '1234567890', 'd@gmail.com'),
(4, 'bellan', 'leonardo', '1122334455', 'b@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
--

CREATE TABLE `recensioni` (
  `libro` int(11) NOT NULL,
  `professore` int(11) NOT NULL,
  `testo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologie`
--

CREATE TABLE `tipologie` (
  `idTipologia` int(11) NOT NULL,
  `tipologia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipologie`
--

INSERT INTO `tipologie` (`idTipologia`, `tipologia`) VALUES
(1, 'Narrativo'),
(3, 'Autobiografico'),
(4, 'Fumetto'),
(5, 'Storico'),
(6, 'pene');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idAccount`);

--
-- Indici per le tabelle `autori`
--
ALTER TABLE `autori`
  ADD PRIMARY KEY (`idAutore`);

--
-- Indici per le tabelle `autorilibro`
--
ALTER TABLE `autorilibro`
  ADD PRIMARY KEY (`libro`,`autore`),
  ADD KEY `autore` (`autore`);

--
-- Indici per le tabelle `caseeditrici`
--
ALTER TABLE `caseeditrici`
  ADD PRIMARY KEY (`idCasaEditrice`);

--
-- Indici per le tabelle `generi`
--
ALTER TABLE `generi`
  ADD PRIMARY KEY (`idGenere`);

--
-- Indici per le tabelle `generilibro`
--
ALTER TABLE `generilibro`
  ADD PRIMARY KEY (`libro`,`genere`),
  ADD KEY `genere` (`genere`);

--
-- Indici per le tabelle `libri`
--
ALTER TABLE `libri`
  ADD PRIMARY KEY (`idLibro`),
  ADD KEY `casaEditrice` (`casaEditrice`),
  ADD KEY `tipologia` (`tipologia`),
  ADD KEY `professore` (`professore`);

--
-- Indici per le tabelle `parolechiave`
--
ALTER TABLE `parolechiave`
  ADD PRIMARY KEY (`idParola`);

--
-- Indici per le tabelle `parolelibro`
--
ALTER TABLE `parolelibro`
  ADD PRIMARY KEY (`libro`,`parola`),
  ADD KEY `parola` (`parola`);

--
-- Indici per le tabelle `professori`
--
ALTER TABLE `professori`
  ADD PRIMARY KEY (`account`);

--
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`libro`,`professore`),
  ADD KEY `professore` (`professore`);

--
-- Indici per le tabelle `tipologie`
--
ALTER TABLE `tipologie`
  ADD PRIMARY KEY (`idTipologia`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `account`
--
ALTER TABLE `account`
  MODIFY `idAccount` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `autori`
--
ALTER TABLE `autori`
  MODIFY `idAutore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `caseeditrici`
--
ALTER TABLE `caseeditrici`
  MODIFY `idCasaEditrice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `generi`
--
ALTER TABLE `generi`
  MODIFY `idGenere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `libri`
--
ALTER TABLE `libri`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `parolechiave`
--
ALTER TABLE `parolechiave`
  MODIFY `idParola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `tipologie`
--
ALTER TABLE `tipologie`
  MODIFY `idTipologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `autorilibro`
--
ALTER TABLE `autorilibro`
  ADD CONSTRAINT `autorilibro_ibfk_1` FOREIGN KEY (`libro`) REFERENCES `libri` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `autorilibro_ibfk_2` FOREIGN KEY (`autore`) REFERENCES `autori` (`idAutore`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `generilibro`
--
ALTER TABLE `generilibro`
  ADD CONSTRAINT `generilibro_ibfk_1` FOREIGN KEY (`libro`) REFERENCES `libri` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generilibro_ibfk_2` FOREIGN KEY (`genere`) REFERENCES `generi` (`idGenere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `libri`
--
ALTER TABLE `libri`
  ADD CONSTRAINT `libri_ibfk_1` FOREIGN KEY (`casaEditrice`) REFERENCES `caseeditrici` (`idCasaEditrice`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `libri_ibfk_2` FOREIGN KEY (`tipologia`) REFERENCES `tipologie` (`idTipologia`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `libri_ibfk_3` FOREIGN KEY (`professore`) REFERENCES `professori` (`account`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `parolelibro`
--
ALTER TABLE `parolelibro`
  ADD CONSTRAINT `parolelibro_ibfk_1` FOREIGN KEY (`libro`) REFERENCES `libri` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parolelibro_ibfk_2` FOREIGN KEY (`parola`) REFERENCES `parolechiave` (`idParola`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `professori`
--
ALTER TABLE `professori`
  ADD CONSTRAINT `professori_ibfk_1` FOREIGN KEY (`account`) REFERENCES `account` (`idAccount`);

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`libro`) REFERENCES `libri` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recensioni_ibfk_2` FOREIGN KEY (`professore`) REFERENCES `professori` (`account`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
