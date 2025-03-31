-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 11:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazyn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID_Admina` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Telefon` varchar(20) DEFAULT NULL,
  `Poziom_dostepu` int(11) DEFAULT NULL,
  `Zatrudniony_od` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_Admina`, `ID_Uzytkownika`, `Imie`, `Nazwisko`, `Telefon`, `Poziom_dostepu`, `Zatrudniony_od`) VALUES
(1, 1, 'Anna', 'Adminska', '123-456-789', 5, '2022-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `ID_Backupu` int(11) NOT NULL,
  `Nazwa_pliku` varchar(255) DEFAULT NULL,
  `Data_utworzenia` datetime DEFAULT NULL,
  `Utworzony_przez` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`ID_Backupu`, `Nazwa_pliku`, `Data_utworzenia`, `Utworzony_przez`) VALUES
(1, 'backup_2025_03_31.sql', '2025-03-31 23:06:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dostawca`
--

CREATE TABLE `dostawca` (
  `ID_Dostawcy` int(11) NOT NULL,
  `Nazwa` varchar(100) DEFAULT NULL,
  `Adres` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostawca`
--

INSERT INTO `dostawca` (`ID_Dostawcy`, `Nazwa`, `Adres`, `Email`, `Telefon`) VALUES
(1, 'TechDostawca Sp. z o.o.', 'ul. Elektronowa 5, Gdańsk', 'kontakt@techdostawca.pl', '111-222-333'),
(2, 'AGD Partner', 'ul. Pralkowa 2, Poznań', 'biuro@agdpartner.pl', '444-555-666');

-- --------------------------------------------------------

--
-- Table structure for table `dostawy`
--

CREATE TABLE `dostawy` (
  `ID_Dostawy` int(11) NOT NULL,
  `ID_Produktu` int(11) DEFAULT NULL,
  `Data_dostawy` date DEFAULT NULL,
  `Ilosc` int(11) DEFAULT NULL,
  `ID_Dostawcy` int(11) DEFAULT NULL,
  `ID_Magazynu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategorie`
--

CREATE TABLE `kategorie` (
  `ID_Kategorii` int(11) NOT NULL,
  `Nazwa` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klient`
--

CREATE TABLE `klient` (
  `ID_Klienta` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Numer_telefonu` varchar(20) DEFAULT NULL,
  `Miasto` varchar(50) DEFAULT NULL,
  `Data_rejestracji` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`ID_Klienta`, `ID_Uzytkownika`, `Imie`, `Nazwisko`, `Email`, `Numer_telefonu`, `Miasto`, `Data_rejestracji`) VALUES
(1, 4, 'Karol', 'Kliencki', 'karol@klient.pl', '555-666-777', 'Kraków', '2023-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `magazyn`
--

CREATE TABLE `magazyn` (
  `ID_Magazynu` int(11) NOT NULL,
  `Lokalizacja` varchar(100) DEFAULT NULL,
  `Pojemnosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magazyn`
--

INSERT INTO `magazyn` (`ID_Magazynu`, `Lokalizacja`, `Pojemnosc`) VALUES
(1, 'Warszawa', 1000),
(2, 'Kraków', 800);

-- --------------------------------------------------------

--
-- Table structure for table `magazynier`
--

CREATE TABLE `magazynier` (
  `ID_Magazyniera` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Stanowisko` varchar(100) DEFAULT NULL,
  `Zmiana` enum('I','II','III') DEFAULT NULL,
  `Uprawnienia_UDT` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magazynier`
--

INSERT INTO `magazynier` (`ID_Magazyniera`, `ID_Uzytkownika`, `Imie`, `Nazwisko`, `Stanowisko`, `Zmiana`, `Uprawnienia_UDT`) VALUES
(1, 2, 'Marek', 'Magazyn', 'wozek widlowy', 'II', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--

CREATE TABLE `produkty` (
  `ID_Produktu` int(11) NOT NULL,
  `Nazwa` varchar(100) DEFAULT NULL,
  `Kategoria` varchar(50) DEFAULT NULL,
  `Cena` decimal(10,2) DEFAULT NULL,
  `Ilosc` int(11) DEFAULT NULL,
  `ID_Magazynu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `raport`
--

CREATE TABLE `raport` (
  `ID_Raportu` int(11) NOT NULL,
  `Typ` varchar(50) DEFAULT NULL,
  `Data_raportu` date DEFAULT NULL,
  `Opis` text DEFAULT NULL,
  `Wygenerowany_przez` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `raport`
--

INSERT INTO `raport` (`ID_Raportu`, `Typ`, `Data_raportu`, `Opis`, `Wygenerowany_przez`) VALUES
(1, 'Stan magazynu', '2025-03-31', 'Raport generowany automatycznie.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_Uzytkownika` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Haslo` varchar(255) NOT NULL,
  `Rola` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_Uzytkownika`, `Login`, `Haslo`, `Rola`) VALUES
(1, 'admin1', 'haslo123', 'Admin'),
(2, 'mag1', 'maghaslo', 'Magazynier'),
(3, 'wlas1', 'wlashaslo', 'Wlasciciel'),
(4, 'klient1', 'klienthaslo', 'Klient');

-- --------------------------------------------------------

--
-- Table structure for table `wlasciciel`
--

CREATE TABLE `wlasciciel` (
  `ID_Wlasciciela` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `NIP` varchar(20) DEFAULT NULL,
  `Nazwa_firmy` varchar(100) DEFAULT NULL,
  `Adres_firmy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wlasciciel`
--

INSERT INTO `wlasciciel` (`ID_Wlasciciela`, `ID_Uzytkownika`, `Imie`, `Nazwisko`, `NIP`, `Nazwa_firmy`, `Adres_firmy`) VALUES
(1, 3, 'Wojciech', 'Wlasciciel', '1234567890', 'Wlasciciel Sp. z o.o.', 'ul. Przykładowa 1, Warszawa');

-- --------------------------------------------------------

--
-- Table structure for table `zamowienia`
--

CREATE TABLE `zamowienia` (
  `ID_Zamowienia` int(11) NOT NULL,
  `ID_Klienta` int(11) DEFAULT NULL,
  `ID_Produktu` int(11) DEFAULT NULL,
  `Ilosc` int(11) DEFAULT NULL,
  `Data_zamowienia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_Admina`),
  ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`ID_Backupu`),
  ADD KEY `Utworzony_przez` (`Utworzony_przez`);

--
-- Indexes for table `dostawca`
--
ALTER TABLE `dostawca`
  ADD PRIMARY KEY (`ID_Dostawcy`);

--
-- Indexes for table `dostawy`
--
ALTER TABLE `dostawy`
  ADD PRIMARY KEY (`ID_Dostawy`),
  ADD KEY `ID_Produktu` (`ID_Produktu`),
  ADD KEY `ID_Dostawcy` (`ID_Dostawcy`),
  ADD KEY `ID_Magazynu` (`ID_Magazynu`);

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`ID_Kategorii`);

--
-- Indexes for table `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`ID_Klienta`),
  ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);

--
-- Indexes for table `magazyn`
--
ALTER TABLE `magazyn`
  ADD PRIMARY KEY (`ID_Magazynu`);

--
-- Indexes for table `magazynier`
--
ALTER TABLE `magazynier`
  ADD PRIMARY KEY (`ID_Magazyniera`),
  ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`ID_Produktu`),
  ADD KEY `ID_Magazynu` (`ID_Magazynu`);

--
-- Indexes for table `raport`
--
ALTER TABLE `raport`
  ADD PRIMARY KEY (`ID_Raportu`),
  ADD KEY `Wygenerowany_przez` (`Wygenerowany_przez`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_Uzytkownika`);

--
-- Indexes for table `wlasciciel`
--
ALTER TABLE `wlasciciel`
  ADD PRIMARY KEY (`ID_Wlasciciela`),
  ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`ID_Zamowienia`),
  ADD KEY `ID_Klienta` (`ID_Klienta`),
  ADD KEY `ID_Produktu` (`ID_Produktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_Admina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `ID_Backupu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dostawca`
--
ALTER TABLE `dostawca`
  MODIFY `ID_Dostawcy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dostawy`
--
ALTER TABLE `dostawy`
  MODIFY `ID_Dostawy` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `ID_Kategorii` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `ID_Klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `magazyn`
--
ALTER TABLE `magazyn`
  MODIFY `ID_Magazynu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `magazynier`
--
ALTER TABLE `magazynier`
  MODIFY `ID_Magazyniera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `ID_Produktu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raport`
--
ALTER TABLE `raport`
  MODIFY `ID_Raportu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wlasciciel`
--
ALTER TABLE `wlasciciel`
  MODIFY `ID_Wlasciciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `ID_Zamowienia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `backup`
--
ALTER TABLE `backup`
  ADD CONSTRAINT `backup_ibfk_1` FOREIGN KEY (`Utworzony_przez`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`);

--
-- Constraints for table `dostawy`
--
ALTER TABLE `dostawy`
  ADD CONSTRAINT `dostawy_ibfk_1` FOREIGN KEY (`ID_Produktu`) REFERENCES `produkty` (`ID_Produktu`),
  ADD CONSTRAINT `dostawy_ibfk_2` FOREIGN KEY (`ID_Dostawcy`) REFERENCES `dostawca` (`ID_Dostawcy`),
  ADD CONSTRAINT `dostawy_ibfk_3` FOREIGN KEY (`ID_Magazynu`) REFERENCES `magazyn` (`ID_Magazynu`);

--
-- Constraints for table `klient`
--
ALTER TABLE `klient`
  ADD CONSTRAINT `klient_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `magazynier`
--
ALTER TABLE `magazynier`
  ADD CONSTRAINT `magazynier_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`ID_Magazynu`) REFERENCES `magazyn` (`ID_Magazynu`);

--
-- Constraints for table `raport`
--
ALTER TABLE `raport`
  ADD CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`Wygenerowany_przez`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`);

--
-- Constraints for table `wlasciciel`
--
ALTER TABLE `wlasciciel`
  ADD CONSTRAINT `wlasciciel_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`ID_Klienta`) REFERENCES `klient` (`ID_Klienta`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`ID_Produktu`) REFERENCES `produkty` (`ID_Produktu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
