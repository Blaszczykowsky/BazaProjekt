<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Magazynier') {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if (!isset($_GET['id'])) {
    header("Location: magazynier_panel.php");
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
    $ilosc = intval($_POST['ilosc']);
    $stmt = $conn->prepare("UPDATE produkty SET Ilosc = ? WHERE ID_Produktu = ?");
    $stmt->bind_param("ii", $ilosc, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: magazynier_panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj Ilość Produktu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edytuj Ilość Produktu</h2>
    <form method="post">
        <p>Produkt: <strong><?php echo htmlspecialchars($produkt['Nazwa']); ?></strong></p>
        <label>Nowa ilość:
            <input type="number" name="ilosc" value="<?php echo $produkt['Ilosc']; ?>" min="0" required>
        </label><br>
        <button type="submit">Zapisz</button>
    </form>
    <a href="magazynier_panel.php">Wróć</a>
</body>
</html>
