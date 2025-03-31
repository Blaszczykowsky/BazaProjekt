<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Klient') {
    header("Location: index.php");
    exit();
}
require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Klienta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h2>Panel Klienta</h2>
        <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['login']); ?> (Klient)</p>
    </header>

    <main>
        <section id="produkty">
            <h3>Dostępne Produkty</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Kategoria</th>
                            <th>Cena</th>
                            <th>Łączna Ilość</th>
                            <th>Dostępność w Magazynach</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM produkty";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['Nazwa']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Kategoria']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Cena']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Ilosc']) . "</td>";

                                // magazyny z dostaw
                                $podquery = $conn->prepare("SELECT m.Lokalizacja, SUM(d.Ilosc) AS Suma
                                                            FROM dostawy d
                                                            JOIN magazyn m ON d.ID_Magazynu = m.ID_Magazynu
                                                            WHERE d.ID_Produktu = ?
                                                            GROUP BY m.ID_Magazynu");
                                $podquery->bind_param("i", $row['ID_Produktu']);
                                $podquery->execute();
                                $podresult = $podquery->get_result();

                                if ($podresult->num_rows > 0) {
                                    echo "<td><ul>";
                                    while($r = $podresult->fetch_assoc()) {
                                        echo "<li>{$r['Lokalizacja']}: {$r['Suma']} szt.</li>";
                                    }
                                    echo "</ul></td>";
                                } else {
                                    echo "<td>Brak danych</td>";
                                }

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Brak produktów</td></tr>";
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
