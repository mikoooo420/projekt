<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyszukiwanie gracza</title>
</head>
<body>
    <?php
    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "csgo_management";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Pobranie nazwy gracza z formularza
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $player_name = $_POST["player_name"];

        // Zapytanie SQL, aby znaleźć gracza o podanej nazwie
        $sql = "SELECT * FROM players WHERE username LIKE '%$player_name%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Wyświetlanie znalezionych graczy
            echo "<h2>Znaleziono graczy:</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["username"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Nie znaleziono gracza o nazwie: $player_name</p>";
        }
    } else {
        // Jeśli zmienna REQUEST_METHOD nie jest POST
        echo "<p>Nieprawidłowe żądanie</p>";
    }

    // Zamykanie połączenia z bazą danych
    $conn->close();
    ?>

    <!-- Przycisk powrotu do dashboardu -->
    <a href="dashboard.php">Powrót do dashboardu</a>
</body>
</html>
