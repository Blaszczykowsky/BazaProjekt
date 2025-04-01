<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Magazynier') {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produkt = intval($_POST['produkt']);
    $ilosc = intval($_POST['ilosc']);
    $magazyn = intval($_POST['magazyn']);

    $stmt = $conn->prepare("INSERT INTO dostawy (ID_Produktu, Data_dostawy, Ilosc, ID_Magazynu) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("iii", $produkt, $ilosc, $magazyn);
    $stmt->execute();
    $stmt->close();

    // Dodaj ilość do produktu
    $stmt2 = $conn->prepare("UPDATE produkty SET Ilosc = Ilosc + ? WHERE ID_Produktu = ?");
    $stmt2->bind_param("ii", $ilosc, $produkt);
    $stmt2->execute();
    $stmt2->close();

    $conn->close();
    header("Location: magazynier_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Dostawę</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dodaj Dostawę</h2>
    <form method="post">
        <label>Produkt:
            <select name="produkt" required>
                <?php
                $result = $conn->query("SELECT ID_Produktu, Nazwa FROM produkty");
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['ID_Produktu']}'>{$row['Nazwa']}</option>";
                }
                ?>
            </select>
        </label><br>

        <label>Ilość:
            <input type="number" name="ilosc" min="1" required>
        </label><br>

        <label>Magazyn:
            <select name="magazyn" required>
                <?php
                $result = $conn->query("SELECT ID_Magazynu, Lokalizacja FROM magazyn");
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['ID_Magazynu']}'>{$row['Lokalizacja']}</option>";
                }
                ?>
            </select>
        </label><br>

        <button type="submit">Zarejestruj Dostawę</button>
    </form>
    <a href="magazynier_panel.php">Wróć</a>
</body>
</html>
