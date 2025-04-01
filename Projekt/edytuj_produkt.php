<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if (!isset($_GET['id'])) {
    header("Location: wlasciciel_panel.php");
    exit();
}

$id = intval($_GET['id']);

$query = $conn->prepare("SELECT * FROM produkty WHERE ID_Produktu = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows !== 1) {
    echo "Produkt nie istnieje.";
    exit();
}

$produkt = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $_POST['nazwa'];
    $kategoria = $_POST['kategoria'];
    $cena = floatval($_POST['cena']);
    $ilosc = intval($_POST['ilosc']);

    $stmt = $conn->prepare("UPDATE produkty SET Nazwa = ?, Kategoria = ?, Cena = ?, Ilosc = ? WHERE ID_Produktu = ?");
    $stmt->bind_param("ssdii", $nazwa, $kategoria, $cena, $ilosc, $id);
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
    <title>Edytuj Produkt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edytuj Produkt</h2>
    <form method="post">
        <label>Nazwa: <input type="text" name="nazwa" value="<?php echo htmlspecialchars($produkt['Nazwa']); ?>" required></label><br>
        <label>Kategoria: <input type="text" name="kategoria" value="<?php echo htmlspecialchars($produkt['Kategoria']); ?>" required></label><br>
        <label>Cena: <input type="number" step="0.01" name="cena" value="<?php echo $produkt['Cena']; ?>" required></label><br>
        <label>Ilość: <input type="number" name="ilosc" value="<?php echo $produkt['Ilosc']; ?>" required></label><br>
        <button type="submit">Zapisz zmiany</button>
    </form>
    <a href="wlasciciel_panel.php">Wróć</a>
</body>
</html>
