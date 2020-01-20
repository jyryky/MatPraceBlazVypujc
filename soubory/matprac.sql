-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 20. led 2020, 19:49
-- Verze serveru: 10.4.11-MariaDB
-- Verze PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `matprac`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `mp_produkty`
--

CREATE TABLE `mp_produkty` (
  `ID` int(11) NOT NULL,
  `Název` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `Kategorie` enum('Audio','Video','Light','Grip') COLLATE utf8_czech_ci NOT NULL,
  `Cena` int(11) NOT NULL,
  `Dostupnost` enum('Dostupné','Nedostupné') COLLATE utf8_czech_ci NOT NULL,
  `Popis` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `mp_produkty`
--

INSERT INTO `mp_produkty` (`ID`, `Název`, `Kategorie`, `Cena`, `Dostupnost`, `Popis`) VALUES
(1, 'RCF art 312 mkIV', 'Audio', 500, 'Dostupné', 'Reproduktor'),
(2, 'Soundcraft Si Expression 1', 'Audio', 1000, 'Dostupné', 'mixážní pult'),
(3, 'FHR 500', 'Light', 300, 'Dostupné', 'světlo žluté'),
(12, 'bla', 'Video', 48, 'Dostupné', '587');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `mp_produkty`
--
ALTER TABLE `mp_produkty`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `mp_produkty`
--
ALTER TABLE `mp_produkty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
