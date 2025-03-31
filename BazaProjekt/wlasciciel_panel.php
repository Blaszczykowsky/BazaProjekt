<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
include("db.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Właściciela</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Panel Właściciela</h2>
            <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['user_login']); ?></p>
        </header>
        
        <nav>
            <ul>
                <li><a href="#statystyki">Statystyki Sprzedaży</a></li>
                <li><a href="#raporty">Raporty</a></li>
                <li><a href="#finanse">Finanse</a></li>
                <li><a href="#pracownicy">Pracownicy</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="statystyki">
                <h3>Statystyki Sprzedaży</h3>
                
                <div class="stats-container">
                    <div class="stat-box">
                        <h4>Dzienna Sprzedaż</h4>
                        <?php
                        $today = date('Y-m-d');
                        $query = "SELECT COUNT(*) as total, SUM(Suma) as suma FROM zamowienie WHERE Data = '$today'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        ?>
                        <p>Ilość zamówień: <?php echo $row['total'] ?? 0; ?></p>
                        <p>Wartość: <?php echo number_format($row['suma'] ?? 0, 2); ?> zł</p>
                    </div>
                    
                    <div class="stat-box">
                        <h4>Miesięczna Sprzedaż</h4>
                        <?php
                        $month_start = date('Y-m-01');
                        $month_end = date('Y-m-t');
                        $query = "SELECT COUNT(*) as total, SUM(Suma) as suma FROM zamowienie WHERE Data BETWEEN '$month_start' AND '$month_end'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        ?>
                        <p>Ilość zamówień: <?php echo $row['total'] ?? 0; ?></p>
                        <p>Wartość: <?php echo number_format($row['suma'] ?? 0, 2); ?> zł</p>
                    </div>
                    
                    <div class="stat-box">
                        <h4>Najpopularniejszy Produkt</h4>
                        <?php
                        $query = "SELECT p.Nazwa, COUNT(zp.ID_Produktu) as ilosc
                                  FROM zamowienie_produkt zp
                                  JOIN produkt p ON zp.ID_Produktu = p.ID_Produktu
                                  GROUP BY zp.ID_Produktu
                                  ORDER BY ilosc DESC
                                  LIMIT 1";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<p>" . htmlspecialchars($row['Nazwa']) . "</p>";
                            echo "<p>Ilość zamówień: " . $row['ilosc'] . "</p>";
                        } else {
                            echo "<p>Brak danych</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>
            
            <section id="raporty">
                <h3>Raporty</h3>
                <div class="action-buttons">
                    <a href="generuj_raport.php?typ=sprzedaz" class="btn">Raport Sprzedaży</a>
                    <a href="generuj_raport.php?typ=finanse" class="btn">Raport Finansowy</a>
                    <a href="generuj_raport.php?typ=magazyn" class="btn">Raport Magazynowy</a>
                </div>
                
                <div class="data-table">
                    <h4>Ostatnie Raporty</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Typ</th>
                                <th>Data</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM raport ORDER BY Data_utworzenia DESC LIMIT 10";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Raportu']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Typ']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Data_utworzenia']) . "</td>";
                                    echo "<td>
                                            <a href='pokaz_raport.php?id=" . $row['ID_Raportu'] . "'>Pokaż</a> | 
                                            <a href='pobierz_raport.php?id=" . $row['ID_Raportu'] . "'>Pobierz</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Brak raportów</td></tr>";
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