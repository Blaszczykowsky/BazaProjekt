-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 08:58 AM
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
-- Table structure for table `administrator_systemu`
--

CREATE TABLE `administrator_systemu` (
  `ID_Admina` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Rola` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `administrator_systemu`
--

INSERT INTO `administrator_systemu` (`ID_Admina`, `Imie`, `Nazwisko`, `Rola`) VALUES
(1, 'Paweł', 'Szymański', 'Główny administrator'),
(2, 'Ewa', 'Kowalczyk', 'Administrator IT');

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `ID_Backupu` int(11) NOT NULL,
  `ID_Admina` int(11) DEFAULT NULL,
  `Data_utworzenia` date DEFAULT NULL,
  `Rozmiar` decimal(10,2) DEFAULT NULL,
  `Lokalizacja` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`ID_Backupu`, `ID_Admina`, `Data_utworzenia`, `Rozmiar`, `Lokalizacja`) VALUES
(1, 1, '2025-03-10', 2.50, '/backups/backup1.sql'),
(2, 2, '2025-03-15', 3.00, '/backups/backup2.sql');

-- --------------------------------------------------------

--
-- Table structure for table `dostawa`
--

CREATE TABLE `dostawa` (
  `ID_Dostawy` int(11) NOT NULL,
  `ID_Magazynu` int(11) DEFAULT NULL,
  `ID_Pracownika` int(11) DEFAULT NULL,
  `Data_dostawy` date DEFAULT NULL,
  `Dostawca` varchar(100) DEFAULT NULL,
  `Status` enum('Oczekująca','Dostarczona') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `dostawa`
--

INSERT INTO `dostawa` (`ID_Dostawy`, `ID_Magazynu`, `ID_Pracownika`, `Data_dostawy`, `Dostawca`, `Status`) VALUES
(1, 1, 1, '2025-03-15', 'ABC Logistics', 'Dostarczona'),
(2, 2, 2, '2025-03-16', 'XYZ Transport', 'Oczekująca');

-- --------------------------------------------------------

--
-- Table structure for table `dostawca`
--

CREATE TABLE `dostawca` (
  `ID_Dostawcy` int(11) NOT NULL,
  `Nazwa` varchar(100) DEFAULT NULL,
  `Kontakt` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `dostawca`
--

INSERT INTO `dostawca` (`ID_Dostawcy`, `Nazwa`, `Kontakt`) VALUES
(1, 'ABC Logistics', 'abc@logistics.com'),
(2, 'XYZ Transport', 'xyz@transport.com');

-- --------------------------------------------------------

--
-- Table structure for table `klient`
--

CREATE TABLE `klient` (
  `ID_Klienta` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`ID_Klienta`, `Imie`, `Nazwisko`, `Email`, `Telefon`) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@example.com', '123456789'),
(2, 'Anna', 'Nowak', 'anna.nowak@example.com', '987654321'),
(3, 'Jan', 'Kowalski', 'jan.kowalski@example.com', '123456789'),
(4, 'Anna', 'Nowak', 'anna.nowak@example.com', '987654321'),
(5, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com', '111222333');

-- --------------------------------------------------------

--
-- Table structure for table `magazyn`
--

CREATE TABLE `magazyn` (
  `ID_Magazynu` int(11) NOT NULL,
  `Lokalizacja` varchar(100) DEFAULT NULL,
  `Pojemnosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `magazyn`
--

INSERT INTO `magazyn` (`ID_Magazynu`, `Lokalizacja`, `Pojemnosc`) VALUES
(1, 'Warszawa', 5000),
(2, 'Kraków', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `pracownik_magazynu`
--

CREATE TABLE `pracownik_magazynu` (
  `ID_Pracownika` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL,
  `Stanowisko` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `pracownik_magazynu`
--

INSERT INTO `pracownik_magazynu` (`ID_Pracownika`, `Imie`, `Nazwisko`, `Stanowisko`) VALUES
(1, 'Marek', 'Dąbrowski', 'Magazynier'),
(2, 'Katarzyna', 'Lewandowska', 'Kierownik');

-- --------------------------------------------------------

--
-- Table structure for table `produkt`
--

CREATE TABLE `produkt` (
  `ID_Produktu` int(11) NOT NULL,
  `Nazwa` varchar(100) DEFAULT NULL,
  `Cena` decimal(10,2) DEFAULT NULL,
  `Opis` text DEFAULT NULL,
  `Kategoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `produkt`
--

INSERT INTO `produkt` (`ID_Produktu`, `Nazwa`, `Cena`, `Opis`, `Kategoria`) VALUES
(1, 'Laptop', 2500.00, 'Nowoczesny laptop z procesorem Intel i7', 'Elektronika'),
(2, 'Smartfon', 1500.00, 'Telefon z 6.5-calowym ekranem OLED', 'Elektronika'),
(3, 'Klawiatura mechaniczna', 300.00, 'Podświetlana klawiatura dla graczy', 'Akcesoria');

-- --------------------------------------------------------

--
-- Table structure for table `raport`
--

CREATE TABLE `raport` (
  `ID_Raportu` int(11) NOT NULL,
  `ID_Wlasciciela` int(11) DEFAULT NULL,
  `Typ` varchar(50) DEFAULT NULL,
  `Data_utworzenia` date DEFAULT NULL,
  `Zawartosc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `raport`
--

INSERT INTO `raport` (`ID_Raportu`, `ID_Wlasciciela`, `Typ`, `Data_utworzenia`, `Zawartosc`) VALUES
(1, 1, 'Finansowy', '2025-03-17', 'Raport finansowy za marzec'),
(2, 2, 'Sprzedażowy', '2025-03-18', 'Analiza sprzedaży w lutym');

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `ID_Uzytkownika` int(11) NOT NULL,
  `ID_Admina` int(11) DEFAULT NULL,
  `Login` varchar(50) DEFAULT NULL,
  `Haslo` varchar(255) DEFAULT NULL,
  `Rola` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`ID_Uzytkownika`, `ID_Admina`, `Login`, `Haslo`, `Rola`) VALUES
(1, 1, 'admin1', 'haslo123', 'SuperAdmin'),
(2, 2, 'admin2', 'haslo456', 'Moderator');

-- --------------------------------------------------------

--
-- Table structure for table `wlasciciel_sklepu`
--

CREATE TABLE `wlasciciel_sklepu` (
  `ID_Wlasciciela` int(11) NOT NULL,
  `Imie` varchar(50) DEFAULT NULL,
  `Nazwisko` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `wlasciciel_sklepu`
--

INSERT INTO `wlasciciel_sklepu` (`ID_Wlasciciela`, `Imie`, `Nazwisko`) VALUES
(1, 'Tomasz', 'Zieliński'),
(2, 'Karolina', 'Mazur');

-- --------------------------------------------------------

--
-- Table structure for table `zamowienie`
--

CREATE TABLE `zamowienie` (
  `ID_Zamowienia` int(11) NOT NULL,
  `ID_Klienta` int(11) DEFAULT NULL,
  `Data` date DEFAULT NULL,
  `Status` enum('Nowe','W trakcie','Zrealizowane') DEFAULT NULL,
  `Suma` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zamowienie`
--

INSERT INTO `zamowienie` (`ID_Zamowienia`, `ID_Klienta`, `Data`, `Status`, `Suma`) VALUES
(1, 1, '2025-03-20', 'Nowe', 150.50),
(2, 2, '2025-03-18', 'W trakcie', 300.00),
(3, 3, '2025-03-19', 'Zrealizowane', 99.99);

-- --------------------------------------------------------

--
-- Table structure for table `zamowienie_produkt`
--

CREATE TABLE `zamowienie_produkt` (
  `ID_Zamowienia` int(11) NOT NULL,
  `ID_Produktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zamowienie_produkt`
--

INSERT INTO `zamowienie_produkt` (`ID_Zamowienia`, `ID_Produktu`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator_systemu`
--
ALTER TABLE `administrator_systemu`
  ADD PRIMARY KEY (`ID_Admina`);

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`ID_Backupu`),
  ADD KEY `ID_Admina` (`ID_Admina`);

--
-- Indexes for table `dostawa`
--
ALTER TABLE `dostawa`
  ADD PRIMARY KEY (`ID_Dostawy`),
  ADD KEY `ID_Magazynu` (`ID_Magazynu`),
  ADD KEY `ID_Pracownika` (`ID_Pracownika`);

--
-- Indexes for table `dostawca`
--
ALTER TABLE `dostawca`
  ADD PRIMARY KEY (`ID_Dostawcy`);

--
-- Indexes for table `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`ID_Klienta`);

--
-- Indexes for table `magazyn`
--
ALTER TABLE `magazyn`
  ADD PRIMARY KEY (`ID_Magazynu`);

--
-- Indexes for table `pracownik_magazynu`
--
ALTER TABLE `pracownik_magazynu`
  ADD PRIMARY KEY (`ID_Pracownika`);

--
-- Indexes for table `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`ID_Produktu`);

--
-- Indexes for table `raport`
--
ALTER TABLE `raport`
  ADD PRIMARY KEY (`ID_Raportu`),
  ADD KEY `ID_Wlasciciela` (`ID_Wlasciciela`);

--
-- Indexes for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`ID_Uzytkownika`),
  ADD KEY `ID_Admina` (`ID_Admina`);

--
-- Indexes for table `wlasciciel_sklepu`
--
ALTER TABLE `wlasciciel_sklepu`
  ADD PRIMARY KEY (`ID_Wlasciciela`);

--
-- Indexes for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`ID_Zamowienia`),
  ADD KEY `ID_Klienta` (`ID_Klienta`);

--
-- Indexes for table `zamowienie_produkt`
--
ALTER TABLE `zamowienie_produkt`
  ADD PRIMARY KEY (`ID_Zamowienia`,`ID_Produktu`),
  ADD KEY `ID_Produktu` (`ID_Produktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator_systemu`
--
ALTER TABLE `administrator_systemu`
  MODIFY `ID_Admina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `ID_Backupu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dostawa`
--
ALTER TABLE `dostawa`
  MODIFY `ID_Dostawy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dostawca`
--
ALTER TABLE `dostawca`
  MODIFY `ID_Dostawcy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `ID_Klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `magazyn`
--
ALTER TABLE `magazyn`
  MODIFY `ID_Magazynu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pracownik_magazynu`
--
ALTER TABLE `pracownik_magazynu`
  MODIFY `ID_Pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `ID_Produktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `raport`
--
ALTER TABLE `raport`
  MODIFY `ID_Raportu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wlasciciel_sklepu`
--
ALTER TABLE `wlasciciel_sklepu`
  MODIFY `ID_Wlasciciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `ID_Zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backup`
--
ALTER TABLE `backup`
  ADD CONSTRAINT `backup_ibfk_1` FOREIGN KEY (`ID_Admina`) REFERENCES `administrator_systemu` (`ID_Admina`);

--
-- Constraints for table `dostawa`
--
ALTER TABLE `dostawa`
  ADD CONSTRAINT `dostawa_ibfk_1` FOREIGN KEY (`ID_Magazynu`) REFERENCES `magazyn` (`ID_Magazynu`),
  ADD CONSTRAINT `dostawa_ibfk_2` FOREIGN KEY (`ID_Pracownika`) REFERENCES `pracownik_magazynu` (`ID_Pracownika`);

--
-- Constraints for table `raport`
--
ALTER TABLE `raport`
  ADD CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`ID_Wlasciciela`) REFERENCES `wlasciciel_sklepu` (`ID_Wlasciciela`);

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`ID_Admina`) REFERENCES `administrator_systemu` (`ID_Admina`);

--
-- Constraints for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD CONSTRAINT `zamowienie_ibfk_1` FOREIGN KEY (`ID_Klienta`) REFERENCES `klient` (`ID_Klienta`);

--
-- Constraints for table `zamowienie_produkt`
--
ALTER TABLE `zamowienie_produkt`
  ADD CONSTRAINT `zamowienie_produkt_ibfk_1` FOREIGN KEY (`ID_Zamowienia`) REFERENCES `zamowienie` (`ID_Zamowienia`),
  ADD CONSTRAINT `zamowienie_produkt_ibfk_2` FOREIGN KEY (`ID_Produktu`) REFERENCES `produkt` (`ID_Produktu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
