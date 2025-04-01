<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['rola'] !== 'Admin' && $_SESSION['rola'] !== 'SuperAdmin')) {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit();
}

$id = intval($_GET['id']);

// Sprawdzenie, czy użytkownik istnieje
$query = $conn->prepare("SELECT * FROM uzytkownicy WHERE ID_Uzytkownika = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows !== 1) {
    echo "Użytkownik nie istnieje.";
    exit();
}

// Usuwanie z tabel roli (dzięki ON DELETE CASCADE to niekonieczne, ale robimy to jawnie)
$conn->query("DELETE FROM admin WHERE ID_Uzytkownika = $id");
$conn->query("DELETE FROM magazynier WHERE ID_Uzytkownika = $id");
$conn->query("DELETE FROM wlasciciel WHERE ID_Uzytkownika = $id");
$conn->query("DELETE FROM klient WHERE ID_Uzytkownika = $id");

// Usuwanie z głównej tabeli
$stmt = $conn->prepare("DELETE FROM uzytkownicy WHERE ID_Uzytkownika = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: admin_panel.php");
exit();
?>
