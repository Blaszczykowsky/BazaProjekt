<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $_POST['nazwa'];
    $kategoria = $_POST['kategoria'];
    $cena = floatval($_POST['cena']);
    $ilosc = intval($_POST['ilosc']);

    $stmt = $conn->prepare("INSERT INTO produkty (Nazwa, Kategoria, Cena, Ilosc) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nazwa, $kategoria, $cena, $ilosc);
    $stmt->execute();
    $stmt->close();

    header("Location: wlasciciel_panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Produkt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dodaj Produkt</h2>
    <form method="post">
        <label>Nazwa: <input type="text" name="nazwa" required></label><br>
        <label>Kategoria: <input type="text" name="kategoria" required></label><br>
        <label>Cena: <input type="number" step="0.01" name="cena" required></label><br>
        <label>Ilość: <input type="number" name="ilosc" required></label><br>
        <button type="submit">Dodaj</button>
    </form>
    <a href="wlasciciel_panel.php">Wróć</a>
</body>
</html>
