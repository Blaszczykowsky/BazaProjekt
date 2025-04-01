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

$query = $conn->prepare("SELECT * FROM magazyn WHERE ID_Magazynu = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows !== 1) {
    echo "Magazyn nie istnieje.";
    exit();
}

$magazyn = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lokalizacja = $_POST['lokalizacja'];
    $pojemnosc = intval($_POST['pojemnosc']);

    $stmt = $conn->prepare("UPDATE magazyn SET Lokalizacja = ?, Pojemnosc = ? WHERE ID_Magazynu = ?");
    $stmt->bind_param("sii", $lokalizacja, $pojemnosc, $id);
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
    <title>Edytuj Magazyn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edytuj Magazyn</h2>
    <form method="post">
        <label>Lokalizacja: <input type="text" name="lokalizacja" value="<?php echo htmlspecialchars($magazyn['Lokalizacja']); ?>" required></label><br>
        <label>Pojemność: <input type="number" name="pojemnosc" value="<?php echo $magazyn['Pojemnosc']; ?>" required></label><br>
        <button type="submit">Zapisz zmiany</button>
    </form>
    <a href="wlasciciel_panel.php">Wróć</a>
</body>
</html>
