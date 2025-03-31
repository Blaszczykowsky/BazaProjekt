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

// 1. Usuń wszystkie dostawy powiązane z tym produktem
$stmt1 = $conn->prepare("DELETE FROM dostawy WHERE ID_Produktu = ?");
$stmt1->bind_param("i", $id);
$stmt1->execute();
$stmt1->close();

// 2. Usuń sam produkt
$stmt2 = $conn->prepare("DELETE FROM produkty WHERE ID_Produktu = ?");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$stmt2->close();

$conn->close();

// 3. Przekierowanie
header("Location: wlasciciel_panel.php");
exit();
?>
