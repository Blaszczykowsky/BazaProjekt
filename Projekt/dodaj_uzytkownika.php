<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['rola'] !== 'Admin' && $_SESSION['rola'] !== 'SuperAdmin')) {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $rola = $_POST['rola'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];

    // Dodaj do uzytkownicy
    $stmt = $conn->prepare("INSERT INTO uzytkownicy (Login, Haslo, Rola) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $login, $haslo, $rola);
    $stmt->execute();
    $id_uzytkownika = $stmt->insert_id;
    $stmt->close();

    // Dodaj do odpowiedniej tabeli roli
    switch ($rola) {
        case 'Admin':
            $stmt = $conn->prepare("INSERT INTO admin (ID_Uzytkownika, Imie, Nazwisko, Telefon, Poziom_dostepu, Zatrudniony_od) VALUES (?, ?, ?, '', 1, NOW())");
            $stmt->bind_param("iss", $id_uzytkownika, $imie, $nazwisko);
            break;
        case 'Magazynier':
            $stmt = $conn->prepare("INSERT INTO magazynier (ID_Uzytkownika, Imie, Nazwisko, Stanowisko, Zmiana, Uprawnienia_UDT) VALUES (?, ?, ?, 'brak', 'I', 0)");
            $stmt->bind_param("iss", $id_uzytkownika, $imie, $nazwisko);
            break;
        case 'Wlasciciel':
            $stmt = $conn->prepare("INSERT INTO wlasciciel (ID_Uzytkownika, Imie, Nazwisko, NIP, Nazwa_firmy, Adres_firmy) VALUES (?, ?, ?, '', '', '')");
            $stmt->bind_param("iss", $id_uzytkownika, $imie, $nazwisko);
            break;
        case 'Klient':
            $stmt = $conn->prepare("INSERT INTO klient (ID_Uzytkownika, Imie, Nazwisko, Email, Numer_telefonu, Miasto, Data_rejestracji) VALUES (?, ?, ?, '', '', '', NOW())");
            $stmt->bind_param("iss", $id_uzytkownika, $imie, $nazwisko);
            break;
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dodaj Użytkownika</h2>
    <form method="post">
        <label>Login: <input type="text" name="login" required></label><br>
        <label>Hasło: <input type="password" name="haslo" required></label><br>
        <label>Rola:
            <select name="rola" required>
                <option value="Admin">Admin</option>
                <option value="Magazynier">Magazynier</option>
                <option value="Wlasciciel">Wlasciciel</option>
                <option value="Klient">Klient</option>
            </select>
        </label><br>
        <label>Imię: <input type="text" name="imie" required></label><br>
        <label>Nazwisko: <input type="text" name="nazwisko" required></label><br>
        <button type="submit">Dodaj</button>
    </form>
    <a href="admin_panel.php">Wróć do panelu</a>
</body>
</html>
