<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'SuperAdmin') {
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
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Panel Administratora</h2>
            <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['user_login']); ?></p>
        </header>
        
        <nav>
            <ul>
                <li><a href="#uzytkownicy">Zarządzanie Użytkownikami</a></li>
                <li><a href="#produkty">Zarządzanie Produktami</a></li>
                <li><a href="#magazyny">Zarządzanie Magazynami</a></li>
                <li><a href="#raporty">Raporty</a></li>
                <li><a href="#backupy">Kopie Zapasowe</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="uzytkownicy">
                <h3>Zarządzanie Użytkownikami</h3>
                <div class="action-buttons">
                    <a href="dodaj_uzytkownika.php" class="btn">Dodaj Użytkownika</a>
                    <a href="edytuj_uzytkownika.php" class="btn">Edytuj Użytkownika</a>
                    <a href="usun_uzytkownika.php" class="btn">Usuń Użytkownika</a>
                </div>
                
                <div class="data-table">
                    <h4>Lista Użytkowników</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Login</th>
                                <th>Rola</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT ID_Uzytkownika, Login, Rola FROM uzytkownik";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Uzytkownika']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Login']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Rola']) . "</td>";
                                    echo "<td>
                                            <a href='edytuj_uzytkownika.php?id=" . $row['ID_Uzytkownika'] . "'>Edytuj</a> | 
                                            <a href='usun_uzytkownika.php?id=" . $row['ID_Uzytkownika'] . "' onclick='return confirm(\"Czy na pewno chcesz usunąć?\");'>Usuń</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Brak użytkowników</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section id="backupy">
                <h3>Kopie Zapasowe</h3>
                <div class="action-buttons">
                    <a href="utworz_backup.php" class="btn">Utwórz Kopię Zapasową</a>
                    <a href="przywroc_backup.php" class="btn">Przywróć z Kopii</a>
                </div>
                
                <div class="data-table">
                    <h4>Historia Kopii Zapasowych</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Rozmiar</th>
                                <th>Lokalizacja</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM backup";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Backupu']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Data_utworzenia']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Rozmiar']) . " MB</td>";
                                    echo "<td>" . htmlspecialchars($row['Lokalizacja']) . "</td>";
                                    echo "<td>
                                            <a href='przywroc_backup.php?id=" . $row['ID_Backupu'] . "'>Przywróć</a> | 
                                            <a href='usun_backup.php?id=" . $row['ID_Backupu'] . "' onclick='return confirm(\"Czy na pewno chcesz usunąć?\");'>Usuń</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Brak kopii zapasowych</td></tr>";
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