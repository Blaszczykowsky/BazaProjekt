<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lokalizacja = $_POST['lokalizacja'];
    $pojemnosc = intval($_POST['pojemnosc']);

    $stmt = $conn->prepare("INSERT INTO magazyn (Lokalizacja, Pojemnosc) VALUES (?, ?)");
    $stmt->bind_param("si", $lokalizacja, $pojemnosc);
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
    <title>Dodaj Magazyn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dodaj Magazyn</h2>
    <form method="post">
        <label>Lokalizacja: <input type="text" name="lokalizacja" required></label><br>
        <label>Pojemność: <input type="number" name="pojemnosc" required></label><br>
        <button type="submit">Dodaj</button>
    </form>
    <a href="wlasciciel_panel.php">Wróć</a>
</body>
</html>
