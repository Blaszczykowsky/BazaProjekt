<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Raporty</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h2>Raporty Systemowe</h2>
        <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['login']); ?> (Właściciel)</p>
    </header>

    <main>
        <div class="action-buttons">
            <a href="raport_export.php" class="btn">Eksportuj do PDF</a>
            <a href="wlasciciel_panel.php" class="btn">Wróć do Panelu</a>
        </div>

        <section id="produkty">
            <h3>Produkty i Ich Ilość</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th><th>Nazwa</th><th>Kategoria</th><th>Cena</th><th>Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM produkty");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['ID_Produktu']}</td>
                                        <td>{$row['Nazwa']}</td>
                                        <td>{$row['Kategoria']}</td>
                                        <td>{$row['Cena']}</td>
                                        <td>{$row['Ilosc']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Brak produktów</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="dostawy">
            <h3>Historia Dostaw</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Data</th><th>Produkt</th><th>Ilość</th><th>Magazyn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT d.Data_dostawy, p.Nazwa AS Produkt, d.Ilosc, m.Lokalizacja AS Magazyn
                                FROM dostawy d
                                JOIN produkty p ON d.ID_Produktu = p.ID_Produktu
                                JOIN magazyn m ON d.ID_Magazynu = m.ID_Magazynu
                                ORDER BY d.Data_dostawy DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['Data_dostawy']}</td>
                                        <td>{$row['Produkt']}</td>
                                        <td>{$row['Ilosc']}</td>
                                        <td>{$row['Magazyn']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Brak danych o dostawach</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <a href="logout.php" class="logout-btn">Wyloguj się</a>
    </footer>
</div>
</body>
</html>
