<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";
require_once "vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('defaultFont', 'DejaVu Sans');

$html = "<h2>Raport Systemowy</h2>";

// Produkty
$html .= "<h3>Produkty</h3><table border='1' cellpadding='5' cellspacing='0' style='width: 100%; font-size: 12px;'>
<thead><tr>
<th>ID</th><th>Nazwa</th><th>Kategoria</th><th>Cena</th><th>Ilość</th>
</tr></thead><tbody>";

$result = $conn->query("SELECT * FROM produkty");
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['ID_Produktu']}</td>
                <td>{$row['Nazwa']}</td>
                <td>{$row['Kategoria']}</td>
                <td>{$row['Cena']}</td>
                <td>{$row['Ilosc']}</td>
              </tr>";
}
$html .= "</tbody></table><br>";

// Dostawy
$html .= "<h3>Historia Dostaw</h3><table border='1' cellpadding='5' cellspacing='0' style='width: 100%; font-size: 12px;'>
<thead><tr>
<th>Data</th><th>Produkt</th><th>Ilość</th><th>Magazyn</th>
</tr></thead><tbody>";

$sql = "SELECT d.Data_dostawy, p.Nazwa AS Produkt, d.Ilosc, m.Lokalizacja AS Magazyn
        FROM dostawy d
        JOIN produkty p ON d.ID_Produktu = p.ID_Produktu
        JOIN magazyn m ON d.ID_Magazynu = m.ID_Magazynu
        ORDER BY d.Data_dostawy DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['Data_dostawy']}</td>
                <td>{$row['Produkt']}</td>
                <td>{$row['Ilosc']}</td>
                <td>{$row['Magazyn']}</td>
              </tr>";
}
$html .= "</tbody></table>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("raport.pdf", ["Attachment" => false]);
exit();
?>
